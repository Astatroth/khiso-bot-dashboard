<?php

namespace App\Models;

use App\Interfaces\Telegram\HasAdjustableMessagesInterface;
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
class Olympiad extends Model implements HasInlineReplyMarkupInterface, HasAdjustableMessagesInterface
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
        'starts_at' => 'datetime',
        'ends_at' => 'datetime'
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

    /**
     * @return array|null
     */
    public function inlineMarkup(): array|null
    {
        if ($this->status === self::STATUS_STARTED) {
            return [
                'text' => __('Start'),
                'callback_data' => "start_{$this->id}"
            ];
        }

        if ($this->status === self::STATUS_ENDED) {
            return null;
        }

        return null;
    }

    /**
     * @param int|null $studentId
     * @return string
     */
    public function message(?int $studentId): string
    {
        if ($this->status === self::STATUS_CREATED) {
            return $this->description;
        }

        if ($this->status === self::STATUS_ENDED) {
            if ($studentId) {
                $student = Student::find($studentId);

                app()->setLocale($student->language);
            }

            $result = $this->results()->where('student_id', $studentId)->first();
            $strings = [
                __('The ":olympiad" is ended.', ['olympiad' => $this->title]),
                __('Your score is: :score', ['score' => !is_null($result) ? $result->score : 0]),
                __('The general results will be announced later on our telegram channel.')
            ];

            return implode("\r\n\r\n", $strings);
        }

        return __('The ":olympiad" olympiad is started. Press "Start" button below to begin.', ['olympiad' => $this->title]);
    }

    /*
     * Relations
     */

    /**
     * @return HasMany
     */
    public function participants(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'olympiad_id');
    }

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

    /**
     * @return HasMany
     */
    public function results(): HasMany
    {
        return $this->hasMany(OlympiadResult::class, 'olympiad_id');
    }

    /*
     * Scopes
     */
}
