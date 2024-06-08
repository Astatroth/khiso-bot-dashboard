<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DistrictResource extends JsonResource
{
    /**
     * @return object
     */
    public function toObject(): object
    {
        return (object)[
            'id' => $this->resource->id,
            'region_id' => $this->resource->region_id,
            'name' => $this->resource->name
        ];
    }
}
