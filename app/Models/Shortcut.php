<?php

namespace App\Models;

use App\Traits\AttributeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Shortcut extends Model
{
    use AttributeTrait;
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'shortcut_name', 'route_name', 'route_arguments'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'route_arguments' => 'array'
    ];

    /*
     * Scopes
     */

    /**
     * @param Builder $query
     * @param int     $userId
     */
    public function scopeOfUser(Builder $query, int $userId): void
    {
        $query->where('user_id', $userId);
    }
}
