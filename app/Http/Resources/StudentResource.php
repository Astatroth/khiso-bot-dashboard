<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * @return object
     */
    public function toObject(): object
    {
        $object = [
            'id' => $this->resource->id,
            'user_id' => $this->resource->user->id,
            'language' => $this->resource->language,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'full_name' => $this->resource->first_name.' '.$this->resource->last_name,
            'phone_number' => $this->resource->user->phone
        ];

        return (object)$object;
    }
}
