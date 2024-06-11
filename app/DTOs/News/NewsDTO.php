<?php

namespace App\DTOs\News;

use App\Services\NewsService;
use App\Traits\DTOTrait;
use Illuminate\Database\Eloquent\Model;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class NewsDTO extends ValidatedDTO
{
    use DTOTrait;

    protected function rules(): array
    {
        return [];
    }

    protected function defaults(): array
    {
        return [];
    }

    protected function casts(): array
    {
        return [];
    }

    /**
     * @param Model $model
     * @param array $protected
     * @return object|$this
     */
    public function transform(Model $model, array $protected = []): object
    {
        $service = new NewsService();

        $this->parseAttributes($model, $protected);

        $this->parseRelation($model, 'media', NewsMediaDTO::class);

        $this->status = array_merge([
            'value' => $model->status
        ], $service->getStatuses()[$model->status]);

        $this->actionsAllowed = $service->actionsAllowed($model->status);

        return $this;
    }
}
