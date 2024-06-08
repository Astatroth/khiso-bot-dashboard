<?php

namespace App\Models;

use App\Traits\AttributeTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class ConfirmationCode extends Model
{
    use AttributeTrait;
    use HasFactory;

    /**
     * @var string[]
     */
    protected $casts = [
        'expires_at' => 'date'
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'phone_number',
        'code',
        'expires_at'
    ];

    /*
     * Scopes
     */

    /**
     * @param Builder $query
     * @param bool    $true
     * @return void
     */
    public function scopeIsExpired(Builder $query, bool $true = true): void
    {
        $query->where('expires_at', $true ? '<' : '>', now()->format('Y-m-d H:i:s'));
    }
}
