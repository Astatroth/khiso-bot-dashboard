<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
{
    /**
     * @return object
     */
    public function toObject(): object
    {
        return (object)[
            'id' => $this->resource->id,
            'name' => $this->resource->name
        ];
    }
}
