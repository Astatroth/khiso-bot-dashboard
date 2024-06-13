<?php

namespace App\Models;

use App\Traits\AttributeTrait;
use App\Traits\StatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @mixin Builder
 */
class Post extends Model
{
    use AttributeTrait;
    use HasFactory;
    use StatusTrait;

    /**
     * @var string[]
     */
    protected $fillable = [
        'postable_type', 'postable_id', 'status'
    ];

    /*
     * Scopes
     */

    /**
     * @param Builder $query
     * @return void
     */
    public function scopeQueued(Builder $query)
    {
        $query->where('status', self::STATUS_QUEUED);
    }

    /*
     * Relations
     */

    /**
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(PostMessage::class, 'post_id');
    }

    /**
     * @return MorphTo
     */
    public function postable(): MorphTo
    {
        return $this->morphTo();
    }
}
