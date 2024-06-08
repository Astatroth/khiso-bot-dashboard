<?php

namespace App\Models;

use App\Traits\AttributeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin Builder
 */
class Region extends Model
{
    use AttributeTrait;
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'id', 'language', 'name'
    ];

    /*
     * Relations
     */

    /**
     * @return HasMany
     */
    public function districts(): HasMany
    {
        return $this->hasMany(District::class, 'region_id');
    }
}
