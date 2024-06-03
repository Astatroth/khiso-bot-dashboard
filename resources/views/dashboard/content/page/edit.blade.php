@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-form.form :action="route('admin.content.page.save')" :files="true">
                @isset($entry?->id)
                    <input type="hidden" name="id" value="{{ $entry->id }}">
                @endisset

                @isset($entry?->entry_id)
                    <input type="hidden" name="entry_id" value="{{ $entry->entry_id }}">
                @endisset

                <x-card.card>
                    <x-slot:header>
                        <ul class="nav nav-pills mr-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="#general" data-bs-toggle="tab">
                                    {{ __('General') }} *
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#seo" data-bs-toggle="tab">
                                    {{ __('SEO') }}
                                </a>
                            </li>
                        </ul>
                    </x-slot:header>

                    <x-slot:body>
                        <div class="tab-content p-3">
                            <!-- General -->
                            <div class="tab-pane active" id="general">
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
                                    <x-form.label for="title" class="col-md-3">
                                        {{ __('Title') }}
                                    </x-form.label>
                                    <div class="col-md-9">
                                        <input type="text" name="title" id="title" class="form-control"
                                               value="{{ old('title') ?? $entry?->title }}" maxlength="255">
                                    </div>
                                </div>

                                <div class="form-group row required">
                                    <x-form.label for="content" class="col-md-3">
                                        {{ __('Content') }}
                                    </x-form.label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="body"
                                                  id="content">{{ old('body') ?? $entry?->body }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- SEO -->
                            <div class="tab-pane" id="seo">
                                @include('dashboard.seo.form', ['entry' => $entry, 'defaultType' => 'article'])
                            </div>
                        </div>
                    </x-slot:body>

                    <x-slot:footer>
                        <x-form.actions :back="route('admin.content.page.list')"/>
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
            });

            CKEDITOR.replace('content', {
                filebrowserImageBrowseUrl: '/dashboard/laravel-filemanager?type=Files',
                filebrowserImageUploadUrl: '/dashboard/laravel-filemanager/upload?type=Files&_token=',
                filebrowserBrowseUrl: '/dashboard/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/dashboard/laravel-filemanager/upload?type=Files&_token=',
                height: 500,
                language: "{{ $ckeditorLocale }}",
                allowedContent: true
            });
        });
    </script>
@endpush
