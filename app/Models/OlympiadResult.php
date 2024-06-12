<?php

namespace App\Models;

use App\Traits\AttributeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'answers' => 'array'
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'olympiad_id',
        'student_id',
        'answers',
        'score'
    ];
}
