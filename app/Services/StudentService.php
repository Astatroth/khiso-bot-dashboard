<?php

namespace App\Services;

use App\DTOs\Student\StudentDTO;
use App\DTOs\Student\StudentValidatedDTO;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Traits\DynamicTableTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class StudentService
{
    use DynamicTableTrait;

    /**
     * @var string
     */
    protected $model = Student::class;

    /**
     * @param Builder $query
     * @param string  $search
     * @return void
     */
    protected function applyListSearch(Builder &$query, string $search)
    {
        $query->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWherehas('user', function ($q) use ($search) {
                  $q->where('phone', 'like', "%{$search}%");
              });
    }

    /**
     * @param StudentValidatedDTO $dto
     * @param int                 $userId
     * @return void
     */
    public function create(StudentValidatedDTO $dto, int $userId): void
    {
        $nameParts = explode(' ', $dto->full_name);

        Student::create([
            'user_id' => $userId,
            'chat_id' => $dto->chat_id,
            'language' => $dto->language,
            'is_verified' => $dto->is_verified,
            'is_subscribed' => $dto->is_subscribed,
            'first_name' => head($nameParts),
            'last_name' => is_array($nameParts[1]) ? implode(' ', $nameParts[1]) : $nameParts[1],
            'gender' => $dto->gender,
            'date_of_birth' => $dto->date_of_birth,
            'region_id' => $dto->region_id,
            'district_id' => $dto->district_id,
            'institution_id' => $dto->institution_id,
            'grade' => $dto->grade
        ]);
    }

    /**
     * @param int|null $id
     * @return Student|null
     */
    public function find(?int $id): ? Student
    {
        return Student::find($id);
    }

    /**
     * @param int $chatId
     * @return object|null
     */
    public function findByChatId(int $chatId): object|null
    {
        $student = Student::where('chat_id', $chatId)->first();

        return is_null($student) ? null : (new StudentResource($student))->toObject();
    }

    /**
     * @param Builder $query
     * @return void
     */
    protected function includeRelations(Builder &$query)
    {
        $query->with(['user', 'region', 'district', 'institution']);
    }

    /**
     * @param Collection $results
     * @return \Illuminate\Support\Collection
     */
    protected function parseResults(Collection $results): \Illuminate\Support\Collection
    {
        return $results->map(fn ($i) => (new StudentDTO())->transform($i));
    }
}
