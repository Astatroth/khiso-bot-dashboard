<?php

namespace App\Services;

use App\Http\Resources\InstitutionResource;
use App\Models\Institution;
use App\Traits\DynamicTableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class InstitutionService
{
    use DynamicTableTrait;

    /**
     * @var string
     */
    protected $model = Institution::class;

    /**
     * @param Builder $query
     * @param array   $filters
     * @return void
     */
    protected function applyListFilters(Builder &$query, array $filters)
    {
        $query->where('district_id', intval($filters['district_id']));
    }

    /**
     * @param Collection $results
     * @return \Illuminate\Support\Collection
     */
    protected function parseResults(Collection $results): \Illuminate\Support\Collection
    {
        return $results->map(fn ($i) => (new InstitutionResource($i))->toObject());
    }
}
