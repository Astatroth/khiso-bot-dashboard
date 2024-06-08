<?php

namespace App\Services;

use App\Http\Resources\RegionResource;
use App\Models\Region;
use App\Traits\DynamicTableTrait;
use Illuminate\Database\Eloquent\Collection;

class RegionService
{
    use DynamicTableTrait;

    /**
     * @var string
     */
    protected $model = Region::class;

    /**
     * @param Collection $results
     * @return \Illuminate\Support\Collection
     */
    protected function parseResults(Collection $results): \Illuminate\Support\Collection
    {
        return $results->map(fn ($i) => (new RegionResource($i))->toObject());
    }
}
