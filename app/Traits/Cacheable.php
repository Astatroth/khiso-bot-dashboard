<?php

namespace App\Traits;

use Illuminate\Cache\TaggableStore;

trait Cacheable
{
    /**
     * @return bool
     */
    public function cacheIsTaggable(): bool
    {
        return \Cache::getStore() instanceof TaggableStore;
    }
}
