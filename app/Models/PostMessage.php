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
class PostMessage extends Model
{
    use AttributeTrait;
    use HasFactory;

    const TYPE_TEXT = 1;
    const TYPE_PHOTO = 2;
    const TYPE_VIDEO = 3;
    const TYPE_MEDIA_GROUP = 4;

    /**
     * @var string[]
     */
    protected $casts = [
        'message_media' => 'array'
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'post_id',
        'chat_id',
        'message_type',
        'message_content',
        'message_media',
        'message_parse_mode',
        'message_reply_markup'
    ];

    /*
     * Relations
     */

    /**
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
