<?php

namespace App\DTOs\Olympiad;

use App\Services\OlympiadService;
use App\Traits\DTOTrait;
use Illuminate\Database\Eloquent\Model;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class OlympiadDTO extends ValidatedDTO
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

    /**]
     * @param Model $model
     * @param array $protected
     * @return object|$this
     */
    public function transform(Model $model, array $protected = []): object
    {
        $service = new OlympiadService();

        $this->parseAttributes($model, $protected);

        $this->parseFiles($model, 'image');

        $this->status = array_merge([
            'value' => $model->status
        ], $service->getStatuses()[$model->status]);

        $this->editingAllowed = $service->isEditingAllowed($model->status);
        $this->deletionAllowed = $service->isDeletionAllowed($model->status);

        return $this;
    }
}
