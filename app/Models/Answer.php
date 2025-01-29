<?php

namespace App\Models;

use App\Traits\AttributeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class Answer extends Model
{
    use AttributeTrait;
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'question_id',
        'question_number',
        'answer',
    ];

    /**
     * @var string
     */
    protected $table = 'question_answers';
}
