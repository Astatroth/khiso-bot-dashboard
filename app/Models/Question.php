<?php

namespace App\Models;

use App\Interfaces\Telegram\HasInlineReplyMarkupInterface;
use App\Traits\AttributeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

/**
 * @mixin Builder
 */
class Question extends Model implements HasInlineReplyMarkupInterface
{
    use AttributeTrait;
    use HasFactory;

    const TYPE_TEXT = 1;
    const TYPE_IMAGE = 2;
    const TYPE_DOCUMENT = 3;

    /**
     * @var string[]
     */
    protected $fillable = [
        'olympiad_id',
        'title',
        'type',
        'content',
        'correct_answer_cost',
        'wrong_answer_cost'
    ];

    /**
     * Accessors
     */

    public function inlineMarkup(): array
    {
        // TODO: Implement inlineMarkup() method.
    }

    /*
     * Relations
     */

    /**
     * @return HasMany
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class, 'question_id');
    }
}
