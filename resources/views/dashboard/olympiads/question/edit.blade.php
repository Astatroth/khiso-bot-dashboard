@php use App\Models\Question; @endphp

@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-form.form :action="route('admin.olympiad.question.save')" :files="true">
                @isset($entry)
                    <input type="hidden" name="id" value="{{ $entry->id }}">
                @endisset
                <input type="hidden" name="olympiad_id" value="{{ $olympiad->id }}">

                <x-card.card>
                    <x-slot:header>
                        <ul class="nav nav-pills mr-auto p-0">
                            <li class="nav-item">
                                <a class="nav-link active" href="#question" data-bs-toggle="tab">
                                    {{ __('Question') }} *
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#answers" data-bs-toggle="tab">
                                    {{ __('Answers') }} *
                                </a>
                            </li>
                        </ul>
                    </x-slot:header>
                    <x-slot:body>
                        <div class="tab-content p-3">
                            <!-- Question -->
                            <div class="tab-pane active" id="question">
                                <input type="hidden" name="question_type" value="{{ Question::TYPE_DOCUMENT }}">

                                <div class="form-group row{{ is_null($entry) ? ' required' : '' }}">
                                    <x-form.label for="question_content_document" class="col-md-3">
                                        {{ __('Content') }}
                                    </x-form.label>
                                    <div class="col-md-9">
                                        @if (isset($entry) && $entry->type === Question::TYPE_DOCUMENT)
                                            <x-form.input.file accept="pdf" name="question_content_document"
                                                               :current="$entry?->content">
                                                <x-slot:help-text>
                                                    {{ __('Allowed file types: pdf.') }}<br>
                                                    {{ __('Maximum size: 5 MB.') }}
                                                </x-slot:help-text>
                                            </x-form.input.file>
                                        @else
                                            <x-form.input.file accept="pdf" name="question_content_document">
                                                <x-slot:help-text>
                                                    {{ __('Allowed file types: pdf.') }}<br>
                                                    {{ __('Maximum size: 5 MB.') }}
                                                </x-slot:help-text>
                                            </x-form.input.file>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row required">
                                    <x-form.label for="correct_answer_cost" class="col-md-3">
                                        {{ __('Correct answer cost') }}
                                    </x-form.label>
                                    <div class="col-md-1">
                                        <div class="input-group">
                                            <input type="number" name="correct_answer_cost" id="correct_answer_cost"
                                                   class="form-control" min="1"
                                                   value="{{ old('correct_answer_cost', $entry?->correct_answer_cost) }}">
                                            <span class="input-group-text">
                                                > 0
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row required">
                                    <x-form.label for="wrong_answer_cost" class="col-md-3">
                                        {{ __('Wrong answer cost') }}
                                    </x-form.label>
                                    <div class="col-md-1">
                                        <div class="input-group">
                                            <input type="number" name="wrong_answer_cost" id="wrong_answer_cost"
                                                   class="form-control" max="-1"
                                                   value="{{ old('wrong_answer_cost', $entry?->wrong_answer_cost) }}">
                                            <span class="input-group-text">
                                                < 0
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Answers -->
                            <div class="tab-pane" id="answers">
                                <div id="questions-container">
                                    <!-- Dummy -->
                                    <div class="question-group dummy-group form-group" style="display: none;">
                                        <label>
                                            {{ __('Correct answer') }}:
                                            <select name="dummy_variants" class="form-select correct-answer" disabled>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                            </select>
                                        </label>
                                        <button type="button" class="btn btn-danger remove-question">
                                            <i class="fa-duotone fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Real -->
                                    @if (!$entry || !$entry->answers || $entry->answers->isEmpty())
                                        <div class="question-group form-group">
                                            <label>
                                                {{ __('Correct answer') }}:
                                                <select name="variants[1]" class="form-select correct-answer" required>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                </select>
                                            </label>
                                        </div>
                                    @else
                                        @foreach ($entry->answers as $index => $answer)
                                            <div class="question-group form-group">
                                                <span class="question-number-label">{{ $index + 1 }}. </span>
                                                <label>
                                                    {{ __('Correct answer') }}:
                                                    <select name="variants[{{ $answer->id }}]" class="form-select correct-answer" required>
                                                        <option value="A" @selected($answer->answer === 'A')>A</option>
                                                        <option value="B" @selected($answer->answer === 'B')>B</option>
                                                        <option value="C" @selected($answer->answer === 'C')>C</option>
                                                        <option value="D" @selected($answer->answer === 'D')>D</option>
                                                    </select>
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <button type="button" id="add-question" class="btn btn-primary mt-3">{{ __('Add') }}</button>
                            </div>
                        </div>
                    </x-slot:body>
                    <x-slot:footer>
                        <x-form.actions :back="route('admin.olympiad.list')"/>
                    </x-slot:footer>
                </x-card.card>
            </x-form.form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(window).on('pageshow', function () {
            function updateQuestionNumbers() {
                $('#questions-container .question-group:not(.dummy-group)').each(function (index) {
                    const questionNumber = index + 1; // Номер вопроса (начиная с 1)
                    $(this).find('.question-number-label').remove(); // Удаляем старую метку номера
                    $(this).prepend(`<span class="question-number-label">${questionNumber}. </span>`); // Добавляем новую метку номера
                    $(this).find('select').attr('name', `variants[${questionNumber}]`); // Обновляем имя с новым ключом
                });
            }

            // Добавление новой группы
            $('#add-question').on('click', function () {
                const dummyGroup = $('.dummy-group').clone(); // Клонирование dummy-группы
                dummyGroup.removeClass('dummy-group'); // Убираем класс dummy
                dummyGroup.show(); // Делаем группу видимой
                dummyGroup.find('select').prop('disabled', false); // Активируем поле

                // Добавляем новую группу в контейнер
                $('#questions-container').append(dummyGroup);

                // Обновляем номера вопросов и имена
                updateQuestionNumbers();
            });

            // Удаление группы
            $(document).on('click', '.remove-question', function () {
                $(this).closest('.question-group').remove();
                updateQuestionNumbers(); // Обновляем номера вопросов после удаления
            });

            // Инициализация при загрузке
            updateQuestionNumbers();
        });
    </script>
@endpush
