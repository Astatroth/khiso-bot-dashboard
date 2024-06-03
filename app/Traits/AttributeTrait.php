<?php

namespace App\Traits;

trait AttributeTrait
{
    /**
     * Returns all attributes of a model, except hidden ones.
     *
     * @return array
     */
    public function getAllAttributes(): array
    {
        $hidden = $this->getHidden();
        $columns = array_merge($this->getFillable(), $this->getDates(), [$this->getKeyName()]);

        return array_filter($columns, function ($a) use ($hidden) {
            return !in_array($a, $hidden);
        });
    }
}
