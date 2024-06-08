<?php

namespace App\Models;

use App\Traits\AttributeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Translation
 *
 * @method Builder|static ofTranslatedGroups(string $group)
 * @method Builder|static orderByGroupKeys(string $group)
 */
class Translation extends Model
{
    use HasFactory, AttributeTrait;

    const STATUS_CHANGED = 1;
    const STATUS_SAVED = 0;

    /**
     * @var string
     */
    protected $table = 'translations';

    /**
     * @var string[]
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /*
     * Scopes
     */

    /**
     * @param Builder $query
     * @param string $group
     * @return mixed
     */
    public function scopeOfTranslatedGroups($query, string $group)
    {
        return $query->where('group', $group)->whereNotNull('value');
    }

    /**
     * @param Builder $query
     * @param $ordered
     * @return mixed
     */
    public function scopeOrderByGroupKeys($query, $ordered)
    {
        if ($ordered) {
            $query->orderBy('group')->orderBy('key');
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @return mixed
     */
    public function scopeSelectDistinctGroup($query)
    {
        $select = '';

        switch (\DB::getDriverName()) {
            case 'mysql':
                $select = 'DISTINCT `group`';
                break;
            default:
                $select = 'DISTINCT "group"';
                break;
        }

        return $query->select(\DB::raw($select));
    }
}
