<?php

namespace App\Models;

use App\Traits\AttributeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class NewsMedia extends Model
{
    use AttributeTrait;
    use HasFactory;

    const TYPE_PHOTO = 1;
    const TYPE_VIDEO = 2;

    /**
     * @var string[]
     */
    protected $fillable = [
        'news_id',
        'media_type',
        'media_url'
    ];
}
