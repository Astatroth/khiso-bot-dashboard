<?php

namespace App\Models;

use App\Traits\AttributeTrait;
use App\Traits\StatusTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @mixin Builder
 */
class News extends Model
{
    use AttributeTrait;
    use HasFactory;
    use StatusTrait;

    /**
     * @var string[]
     */
    protected $dates = [
        'published_at'
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'url',
        'status',
        'published_at'
    ];

    /*
     * Relations
     */

    /**
     * @return HasMany
     */
    public function media(): HasMany
    {
        return $this->hasMany(NewsMedia::class, 'news_id');
    }

    /**
     * @return MorphOne
     */
    public function post(): MorphOne
    {
        return $this->morphOne(Post::class, 'postable');
    }
}
