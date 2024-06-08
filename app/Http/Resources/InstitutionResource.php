<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InstitutionResource extends JsonResource
{
    /**
     * @return object
     */
    public function toObject(): object
    {
        return (object)[
            'id' => $this->resource->id,
            'district_id' => $this->resource->district_id,
            'name' => $this->resource->name,
            'type' => [
                'id' => $this->resource->type,
                'label' => $this->resource::TYPES[$this->resource->type]
            ]
        ];
    }
}
