<?php

namespace App\DTOs\Olympiad;

use App\Traits\DTOTrait;
use Illuminate\Database\Eloquent\Model;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class QuestionDTO extends ValidatedDTO
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
        $this->parseAttributes($model, $protected);

        $this->parseRelation($model, 'answers', AnswerDTO::class);

        if ($model->type !== $model::TYPE_TEXT) {
            $this->parseFiles($model, 'content');
        }

        return $this;
    }
}
