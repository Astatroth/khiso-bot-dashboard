<?php

namespace App\Models;

use App\Interfaces\Telegram\HasInlineReplyMarkupInterface;
use App\Traits\AttributeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @mixin Builder
 */
class Olympiad extends Model implements HasInlineReplyMarkupInterface
{
    use AttributeTrait;
    use HasFactory;

    const STATUS_CREATED = 1;
    const STATUS_STARTED = 2;
    const STATUS_ENDED = 3;

    /**
     * @var string[]
     */
    protected $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date'
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'starts_at',
        'ends_at',
        'status',
        'time_limit'
    ];

    /*
     * Accessors
     */

    public function inlineMarkup(): array
    {
        return [
            'text' => __('Sign up to participate'),
            'callback_data' => "signup_{$this->id}"
        ];
    }

    /*
     * Relations
     */

    /**
     * @return MorphOne
     */
    public function post(): MorphOne
    {
        return $this->morphOne(Post::class, 'postable');
    }

    /**
     * @return HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'olympiad_id');
    }

    /*
     * Scopes
     */
}
