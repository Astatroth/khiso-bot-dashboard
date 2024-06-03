<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait DynamicTableTrait
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxLoadList(Request $request): JsonResponse
    {
        return response()->json(
            $this->service->loadList(
                $request->page, $request->limit, $request->sorting, $request->search, $request->filters
            )
        );
    }

    /**
     * @param Builder $query
     * @param array   $filters
     */
    protected function applyListFilters(Builder &$query, array $filters)
    {
        //
    }

    /**
     * @param Builder $query
     * @param string  $search
     */
    protected function applyListSearch(Builder &$query, string $search)
    {
        //
    }

    /**
     * @param Builder $query
     * @param array   $sorting
     */
    protected function applyListSorting(Builder &$query, array $sorting)
    {
        if (isset($sorting['column']) && isset($sorting['order'])) {
            $model = $this->getModelInstance();
            $columns = $model->getAllAttributes();

            /**
             * @var string $column
             * @var string $order
             */
            extract($sorting);

            if (in_array($column, $columns)) {
                $query->orderBy($column, $order);
            } else {
                if (strpos($column, '.') !==  false) {
                    [$relation, $column] = explode('.', $column);
                    $query->withAggregate($relation, $column)->orderBy(implode('_', [$relation, $column]), $order);
                }
            }
        }
    }

    /**
     * @return Model
     */
    protected function getModelInstance(): Model
    {
        return new $this->model;
    }

    /**
     * @param Builder $query
     */
    protected function includeRelations(Builder &$query)
    {
        //
    }

    /**
     * @param int         $page
     * @param int         $limit
     * @param array       $sorting
     * @param string|null $search
     * @param array|null  $filters
     * @return array
     */
    public function loadList(
        int $page,
        int $limit,
        array $sorting,
        string $search = null,
        array $filters = null
    ): array
    {
        $model = $this->getModelInstance();
        $query = $model->newQuery();

        // Apply filter
        if (!is_null($filters)) {
            if (method_exists($this, 'applyListFilters')) {
                $this->applyListFilters($query, $filters);
            }
        }

        // Apply search
        if (!empty($search) && mb_strlen($search) >= 3) {
            if (method_exists($this, 'applyListSearch')) {
                $this->applyListSearch($query, $search);
            }
        }

        // Count total
        $total = $query->count($model->getKeyName());

        // Apply Sorting
        if (method_exists($this, 'applyListSorting')) {
            $this->applyListSorting($query, $sorting);
        }

        // Query for results
        if (method_exists($this, 'includeRelations')) {
            $this->includeRelations($query);
        }
        $results = $query->offset(($page - 1) * $limit)->limit($limit)->get();

        // Parse results
        $data = collect();
        if ($results->isNotEmpty()) {
            if (method_exists($this, 'parseResults')) {
                $data = $this->parseResults($results);
            }
        }

        return [
            'total' => $total,
            'rows' => $data
        ];
    }

    /**
     * @param Collection $results
     * @return \Illuminate\Support\Collection
     */
    protected function parseResults(Collection $results): \Illuminate\Support\Collection
    {
        return collect();
    }
}
