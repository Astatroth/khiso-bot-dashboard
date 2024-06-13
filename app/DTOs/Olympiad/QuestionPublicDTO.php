<?php

namespace App\DTOs\Olympiad;

use App\Services\MessageService;
use App\Services\QuestionService;
use App\Traits\DTOTrait;
use Illuminate\Database\Eloquent\Model;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class QuestionPublicDTO extends ValidatedDTO
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
            $this->content = $this->content->url;
        } else {
            $this->content = (new MessageService())->sanitizeContent($this->content);
        }

        $this->answers->map(function ($item) {
            unset($item->is_correct);
        });

        $this->type_label = (new QuestionService())->getTypes()[$this->type];

        return $this;
    }
}
