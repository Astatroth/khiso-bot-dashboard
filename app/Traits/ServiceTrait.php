<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait ServiceTrait
{
    /**
     * @param null $key
     * @return Model|null
     */
    public function find($key = null, array $relations = null)
    {
        if (!is_null($key)) {
            $query = (new $this->model());

            if (!is_null($relations)) {
                $query->with($relations);
            }

            if (is_numeric($key)) {
                return $query->find($key);
            }

            if (is_string($key)) {
                if (property_exists($this, 'searchableAttributes')) {
                    if (is_array($this->searchableAttributes)) {
                        $attributes = $this->searchableAttributes;

                        return $query->where(function ($q) use ($attributes, $key) {
                            foreach ($attributes as $attribute) {
                                $q->orWhere($attribute, $key);
                            }
                        })->first();
                    } else {
                        return $query->where($this->searchableAttributes, $key)->first();
                    }
                }
            }
        }

        return null;
    }
}
