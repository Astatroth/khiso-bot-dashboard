@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-form.form :action="route('admin.content.banner.save')" :files="true">
                @isset($entry?->id)
                    <input type="hidden" name="id" value="{{ $entry->id }}">
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
                            <x-form.label for="title" class="col-md-3">
                                {{ __('Title') }}
                            </x-form.label>
                            <div class="col-md-9">
                                <input type="text" name="title" id="title" class="form-control"
                                       value="{{ old('title') ?? $entry?->title }}" maxlength="255">
                            </div>
                        </div>

                        <div class="form-group row">
                            <x-form.label for="description" class="col-md-3">
                                {{ __('Description') }}
                            </x-form.label>
                            <div class="col-md-9">
                                <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{ old('description') ?? $entry?->description }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row{{ is_null($entry) ? ' required' : '' }}">
                            <x-form.label for="image" class="col-md-3">
                                {{ __('Image') }}
                            </x-form.label>
                            <div class="col-md-9">
                                <x-form.input.image name="image" :current="$entry?->image">
                                    <x-slot:help-text>
                                        {{ __('Allowed file types: jpg, jpeg, png, webp.') }}<br>
                                        {{ __('Maximum size: 5 MB.') }}
                                    </x-slot:help-text>
                                </x-form.input.image>
                            </div>
                        </div>

                        <div class="form-group row">
                            <x-form.label for="link" class="col-md-3">
                                {{ __('Link') }}
                            </x-form.label>
                            <div class="col-md-9">
                                <input type="text" name="link" id="link" class="form-control"
                                       value="{{ old('link') ?? $entry?->link }}"
                                       maxlength="255">
                            </div>
                        </div>

                        <div class="form-group row">
                            <x-form.label for="link_label" class="col-md-3">
                                {{ __('Link label') }}
                            </x-form.label>
                            <div class="col-md-9">
                                <input type="text" name="link_label" id="link_label" class="form-control"
                                       value="{{ old('link_label') ?? $entry?->link_label }}"
                                       maxlength="255">
                            </div>
                        </div>

                        <div class="form-group row">
                            <x-form.label for="location_name" class="col-md-3">
                                {{ __('Location name') }}
                            </x-form.label>
                            <div class="col-md-9">
                                <input type="text" name="location_name" id="location_name" class="form-control"
                                       value="{{ old('location_name') ?? $entry?->location_name }}"
                                       maxlength="255">
                            </div>
                        </div>

                        <div class="form-group row">
                            <x-form.label for="location_location" class="col-md-3">
                                {{ __('Location city') }}
                            </x-form.label>
                            <div class="col-md-9">
                                <input type="text" name="location_location" id="location_location" class="form-control"
                                       value="{{ old('location_location') ?? $entry?->location_location }}"
                                       maxlength="255">
                            </div>
                        </div>
                    </x-slot:body>

                    <x-slot:footer>
                        <x-form.actions :back="route('admin.content.banner.list')"/>
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

            CKEDITOR.replace('description', {
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
