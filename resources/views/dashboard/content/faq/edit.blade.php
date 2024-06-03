@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-form.form :action="route('admin.content.faq.save')" :files="true">
                @isset($entry?->id)
                    <input type="hidden" name="id" value="{{ $entry->id }}">
                @endisset

                @isset($entry?->entry_id)
                    <input type="hidden" name="entry_id" value="{{ $entry->entry_id }}">
                @endisset

                <x-card.card>
                    <x-slot:body>
                        <div class="form-group row">
                            <x-form.label for="language" class="col-md-3">
                                {{ __('Language') }}
                            </x-form.label>
                            <div class="col-md-3">
                                <select name="language" id="language" class="form-select">
                                    @foreach (LaravelLocalization::getLocalesOrder() as $key => $locale)
                                        <option value="{{ $key }}"{{ old('language') === $key || ($entry && $entry->language === $key) ? ' selected' : null }} data-flag="{{ $locale['flag'] ?? $key }}">
                                            {{ $locale['native'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row required">
                            <x-form.label for="question" class="col-md-3">
                                {{ __('Question') }}
                            </x-form.label>
                            <div class="col-md-9">
                                        <textarea class="form-control" name="question"
                                                  id="question">{{ old('question') ?? $entry?->question }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row required">
                            <x-form.label for="answer" class="col-md-3">
                                {{ __('Answer') }}
                            </x-form.label>
                            <div class="col-md-9">
                                        <textarea class="form-control" name="answer"
                                                  id="answer">{{ old('answer') ?? $entry?->answer }}</textarea>
                            </div>
                        </div>
                    </x-slot:body>

                    <x-slot:footer>
                        <x-form.actions :back="route('admin.content.faq.list')"/>
                    </x-slot:footer>
                </x-card.card>
            </x-form.form>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ vendor('select2/css/select2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ vendor('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ vendor('select2/js/select2.full.min.js') }}"></script>
    <script src="{{ vendor('select2/js/i18n/'.(app()->getLocale()).'.js') }}"></script>
    <script>
        $(function () {
            function formatLanguage(language) {
                if (!language.id) {
                    return language.text;
                }

                let $language = $('<span><span class="flag-icon flag-icon-'
                    + language.element.getAttribute('data-flag') + '"></span>&nbsp;' + language.text + '</span>');

                return $language;
            }

            $(function () {
                $('#language').select2({
                    language: '{{ app()->getLocale() }}',
                    minimumResultsForSearch: -1,
                    templateResult: formatLanguage,
                    templateSelection: formatLanguage
                });

                $('#country').select2({
                    language: '{{ app()->getLocale() }}'
                });

                CKEDITOR.replace('question', {
                    filebrowserImageBrowseUrl: '/dashboard/laravel-filemanager?type=Files',
                    filebrowserImageUploadUrl: '/dashboard/laravel-filemanager/upload?type=Files&_token=',
                    filebrowserBrowseUrl: '/dashboard/laravel-filemanager?type=Files',
                    filebrowserUploadUrl: '/dashboard/laravel-filemanager/upload?type=Files&_token=',
                    height: 500,
                    language: "{{ $ckeditorLocale }}",
                    allowedContent: true
                });

                CKEDITOR.replace('answer', {
                    filebrowserImageBrowseUrl: '/dashboard/laravel-filemanager?type=Files',
                    filebrowserImageUploadUrl: '/dashboard/laravel-filemanager/upload?type=Files&_token=',
                    filebrowserBrowseUrl: '/dashboard/laravel-filemanager?type=Files',
                    filebrowserUploadUrl: '/dashboard/laravel-filemanager/upload?type=Files&_token=',
                    height: 500,
                    language: "{{ $ckeditorLocale }}",
                    allowedContent: true
                });
            });
        });
    </script>
@endpush
