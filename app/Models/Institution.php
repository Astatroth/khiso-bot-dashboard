<?php

namespace App\Models;

use App\Traits\AttributeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class Institution extends Model
{
    use AttributeTrait;
    use HasFactory;

    const TYPE_SCHOOL = 1;
    const TYPE_UNIVERSITY = 2;

    const TYPES = [
        self::TYPE_SCHOOL => 'school',
        self::TYPE_UNIVERSITY => 'university'
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'district_id',
        'type',
        'language',
        'name'
    ];
}
