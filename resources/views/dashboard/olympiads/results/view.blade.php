@php use App\Models\Student; @endphp
@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-card.card>
                <x-slot:body>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group row">
                                <x-form.label for="name" class="col-md-3">
                                    {{ __('Name') }}
                                </x-form.label>
                                <div class="col-md-9">
                                    <input type="text" id="name" class="form-control-plaintext" value="{{ $entry->fullname }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group row">
                                <x-form.label for="phone" class="col-md-3">
                                    {{ __('Phone number') }}
                                </x-form.label>
                                <div class="col-md-9">
                                    <input type="text" id="phone" class="form-control-plaintext" value="{{ $entry->student->user->phone }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group row">
                                <x-form.label for="dob" class="col-md-3">
                                    {{ __('Date of birth') }}
                                </x-form.label>
                                <div class="col-md-9">
                                    <input type="text" id="dob" class="form-control-plaintext" value="{{ $entry->student->date_of_birth }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group row">
                                <x-form.label for="gender" class="col-md-3">
                                    {{ __('Gender') }}
                                </x-form.label>
                                <div class="col-md-9">
                                    <input type="text" id="gender" class="form-control-plaintext"
                                           value="{{ $entry->student->gender === Student::GENDER_FEMALE ? __('Female') : __('Male') }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group row">
                                <x-form.label for="region" class="col-md-3">
                                    {{ __('Region') }}
                                </x-form.label>
                                <div class="col-md-9">
                                    <input type="text" id="region" class="form-control-plaintext" value="{{ $entry->student->region->name }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group row">
                                <x-form.label for="district" class="col-md-3">
                                    {{ __('District') }}
                                </x-form.label>
                                <div class="col-md-9">
                                    <input type="text" id="district" class="form-control-plaintext" value="{{ $entry->student->district->name }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="form-group row">
                                <x-form.label for="institution" class="col-md-3">
                                    {{ __('Institution') }}
                                </x-form.label>
                                <div class="col-md-9">
                                    <input type="text" id="institution" class="form-control-plaintext" value="{{ $entry->student->institution->name }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group row">
                                <x-form.label for="grade" class="col-md-3">
                                    {{ __('Grade') }}
                                </x-form.label>
                                <div class="col-md-9">
                                    <input type="text" id="grade" class="form-control-plaintext" value="{{ $entry->student->grade }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @foreach ($answers as $index => $answer)
                            <div class="col-lg-2 col-md-2 col-sm-12 mb-3">
                                <div @class(["card card-outline", "card-success" => $answer['is_correct'], "card-danger" => !$answer['is_correct']])>
                                    <div class="card-body">
                                        <p class="fw-bold">{{ __('Question #:question_number', ['question_number' => $index + 1]) }}</p>
                                        <p class="fw-bold">
                                            {{ __('Answer:') }} <span @class(['text-success' => $answer['is_correct'], 'text-danger' => !$answer['is_correct']])>
                                                {{ $answer['user_answer'] }}
                                                @if (!$answer['is_correct'])
                                                    ({{ $answer['correct_answer'] }})
                                                @endif
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot:body>

                <x-slot:footer>
                    <a href="{{ route('admin.olympiad.result.list', $olympiadId) }}" class="btn btn-outline-secondary">
                        <i class="fa-duotone fa-arrow-left fa-fw"></i>
                        {{ __('buttons.back') }}
                    </a>
                </x-slot:footer>
            </x-card.card>
        </div>
    </div>
@endsection
