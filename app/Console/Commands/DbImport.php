<?php

namespace App\Console\Commands;

use App\Models\Institution;
use App\Models\Region;
use Illuminate\Console\Command;

class DbImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:db-import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $db = \DB::connection('khiso');

        $regionsData = $db->table('regions')->wherenull('parent_id')->get();
        $districtsData = $db->table('subregions')->get();
        $institutionsData = $db->table('educations')->get();

        \DB::transaction(function () use ($regionsData, $districtsData, $institutionsData) {
            foreach ($regionsData as $regionRow) {
                $region = Region::create([
                    'id' => $regionRow->r_key,
                    'language' => $regionRow->lang,
                    'name' => $regionRow->title
                ]);

                foreach ($districtsData->where('parent_key', $regionRow->r_key) as $districtRow) {
                    $district = $region->districts()->create([
                        'id' => $districtRow->s_key,
                        'language' => $districtRow->lang,
                        'name' => $districtRow->title
                    ]);

                    foreach ($institutionsData->where('parent_key', $districtRow->s_key) as $institutionData) {
                        $district->institutions()->create([
                            'type' => $institutionData->type === 'school'
                                ? Institution::TYPE_SCHOOL
                                : Institution::TYPE_UNIVERSITY,
                            'language' => $institutionData->lang,
                            'name' => $institutionData->title
                        ]);
                    }
                }
            }
        });
    }
}
