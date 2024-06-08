<?php

namespace App\Services;

use App\Http\Resources\DistrictResource;
use App\Models\District;
use App\Traits\DynamicTableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class DistrictService
{
    use DynamicTableTrait;

    /**
     * @var string
     */
    protected $model = District::class;

    /**
     * @param Builder $query
     * @param array   $filters
     * @return void
     */
    protected function applyListFilters(Builder &$query, array $filters)
    {
        $query->where('region_id', intval($filters['region_id']));
    }

    /**
     * @param Collection $results
     * @return \Illuminate\Support\Collection
     */
    protected function parseResults(Collection $results): \Illuminate\Support\Collection
    {
        return $results->map(fn ($i) => (new DistrictResource($i))->toObject());
    }
}
