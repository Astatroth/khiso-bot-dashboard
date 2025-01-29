<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait DTOTrait
{
    /**
     * @param mixed $x
     * @return bool
     */
    protected function isDate(mixed $x): bool
    {
        return $x instanceof \Illuminate\Support\Carbon && (date('Y-m-d H:i:s', strtotime($x)) == $x);
    }

    /**
     * @param Model $model
     * @param array $protected
     * @return void
     */
    public function parseAttributes(Model $model, array $protected): void
    {
        $attributes = $model->getAllAttributes();

        foreach ($attributes as $attribute) {
            if (!in_array($attribute, $protected)) {
                if ($this->isDate($model->{$attribute})) {
                    $this->parseTimestamp($model->{$attribute}, $attribute);
                } else {
                    $this->{$attribute} = $model->{$attribute};
                }
            }
        }
    }

    /**
     * @param Model        $model
     * @param array|string $attribute
     * @return void
     */
    public function parseFiles(Model $model, array|string $attribute): void
    {
        if (is_array($attribute)) {
            foreach ($attribute as $attr) {
                $this->parseFiles($model, $attr);
            }
        } else {
            if (!is_null($this->{$attribute})) {
                $this->{$attribute} = (object)[
                    'name' => last(explode('/', $model->{$attribute})),
                    'raw' => $model->{$attribute},
                    'path' => storage_path('app/public/files/shares').$model->{$attribute},
                    'url' => config('app.url').'/storage/files/shares'.$model->{$attribute}
                ];
            }
        }
    }

    /**
     * @param Model       $model
     * @param string      $relation
     * @param string|null $dto
     * @param string      $method
     * @return $this
     */
    public function parseRelation(
        Model $model,
        string $relation,
        string|null $dto = null,
        string $method = 'transform'
    ): self {

        $result = [];
        $resource = $model->{$relation};

        if (!is_null($resource)) {
            if ($resource instanceof Collection) {
                $result = $resource->map(function ($item, $key) use ($dto, $method) {
                    return !is_null($dto) ? (new $dto())->$method($item) : $item;
                });
            } else {
                $result = !is_null($dto) ? (new $dto())->$method($resource) : $resource;
            }
        } else {
            return $this;
        }

        $this->{$relation} = $result;

        return $this;
    }

    /**
     * @param mixed  $value
     * @param string $attribute
     * @return void
     */
    public function parseTimestamp(mixed $value, string $attribute): void
    {
        if (is_null($value)) {
            return;
        }

        $this->{$attribute} = (object)[
            'raw' => $value,
            'date' => $value->format(config('app.locale_settings.date_format')),
            'formatted' => $value->format(config('app.locale_settings.datetime_format')),
            'since' => $value->format('H:i d.m.Y'),
            'until' => $value->format('H:i d.m.Y'),
        ];
    }

    /**
     * @param Model $model
     * @param array $protected
     * @return object|$this
     */
    public function transform(Model $model, array $protected = []): object
    {
        $this->parseAttributes($model, $protected);

        $this->parseFiles($model, 'image');

        return $this;
    }
}
