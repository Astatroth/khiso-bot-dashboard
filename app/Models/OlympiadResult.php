<?php

namespace App\Models;

use App\Traits\AttributeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin Builder
 */
class OlympiadResult extends Model
{
    use AttributeTrait;
    use HasFactory;

    /**
     * @var string[]
     */
    protected $casts = [
        'answers' => 'array',
        'finished_at' => 'datetime'
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'olympiad_id',
        'student_id',
        'answers',
        'score',
        'finished_at'
    ];

    /*
     * Relations
     */

    /**
     * @return BelongsTo
     */
    public function olympiad(): BelongsTo
    {
        return $this->belongsTo(Olympiad::class, 'olympiad_id');
    }

    /**
     * @return BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
