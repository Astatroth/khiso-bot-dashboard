<?php

namespace App\Models;

use App\Traits\AttributeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @mixin Builder
 */
class Seo extends Model
{
    use AttributeTrait;
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'path',
        'language',
        'content_type',
        'content_id',
        'description',
        'og_title',
        'og_type',
        'og_url',
        'og_image'
    ];

    /**
     * @var string
     */
    protected $table = 'seo';

    /*
     * Relations
     */

    /**
     * @return MorphTo
     */
    public function content(): MorphTo
    {
        return $this->morphTo();
    }
}
