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

        if ($model->type !== $model::TYPE_TEXT) {
            //$this->parseFiles($model, 'content');
            //$this->content = $this->content->url;
        } else {
            $this->content = (new MessageService())->sanitizeContent($this->content);
        }

        $this->type_label = (new QuestionService())->getRawTypes()[$this->type];
        $this->answers_count = $model->answers()->count();

        return $this;
    }
}
