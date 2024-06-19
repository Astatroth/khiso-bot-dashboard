<?php

namespace App\DTOs\Student;

use App\Models\Student;
use App\Traits\DTOTrait;
use Illuminate\Database\Eloquent\Model;
use WendellAdriel\ValidatedDTO\ValidatedDTO;

class StudentDTO extends ValidatedDTO
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

    public function transform(Model $model, array $protected = []): object
    {
        $this->parseAttributes($model, $protected);

        $this->parseRelation($model, 'user');
        $this->parseRelation($model, 'region');
        $this->parseRelation($model, 'district');
        $this->parseRelation($model, 'institution');

        $this->fullName = implode(' ', [$model->first_name, $model->last_name]);
        $this->phoneNumber = $model->user->phone;

        if (strpos($this->phoneNumber, '+') === false) {
            $this->phoneNumber = '+'.$this->phoneNumber;
        }

        $this->age = floor(date('Y', time()) - date('Y', strtotime($model->date_of_birth)));
        $this->gender = $model->gender === Student::GENDER_MALE ? __('Male') : __('Female');

        return $this;
    }
}
