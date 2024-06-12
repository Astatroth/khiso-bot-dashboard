<?php

namespace App\Console\Commands;

use App\Services\OlympiadService;
use Illuminate\Console\Command;

class EndOlympiad extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:end-olympiad';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @param OlympiadService $service
     */
    public function __construct(protected OlympiadService $service)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $olympiads = $this->service->getOlympiadsInProgress();

        if ($olympiads->isNotEmpty()) {
            foreach ($olympiads as $olympiad) {
                $this->service->endOlympiad($olympiad->id);
            }
        }
    }
}
