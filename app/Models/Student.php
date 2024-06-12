<?php

namespace App\Models;

use App\Traits\AttributeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin Builder
 */
class Student extends Model
{
    use AttributeTrait;
    use HasFactory;

    const GENDER_FEMALE = 1;
    const GENDER_MALE = 2;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'chat_id',
        'language',
        'is_verified',
        'is_subscribed',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'region_id',
        'district_id',
        'institution_id',
        'grade'
    ];

    /*
     * Relations
     */

    /**
     * @return BelongsTo
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    /**
     * @return BelongsTo
     */
    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    /**
     * @return BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
