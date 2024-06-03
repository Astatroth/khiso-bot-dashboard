@extends('dashboard.layout')

@push('styles')
    <link rel="stylesheet" href="{{ vendor('select2/css/select2.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col">
            <x-form.form :action="route('admin.seo.save')" :files="true">
                @isset($entry)
                    <input type="hidden" name="id" value="{{ $entry->id }}">
                @endisset

                <x-card.card>
                    <x-slot:body>
                        <div class="form-group row required">
                            <label for="path" class="control-label col-form-label text-end col-md-3">
                                {{ __('Path') }}
                            </label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <span class="input-group-text" id="urn-addon"
                                          title="{{ __('App URL with the language prefix') }}">
                                        {{ config('app.url') }}/xx
                                    </span>
                                    <input type="text" class="form-control" id="path" name="path" maxlength="255"
                                           placeholder="/some-page-urn" aria-describedby="path-help-text"
                                           value="{{ old('path') ?? $entry?->path }}">
                                </div>
                                <x-form.text id="path-help-text">
                                    {!! __('Enter a path to a page <strong>without language prefix</strong>, for example: "/some-page-urn".') !!}<br>
                                    {{ __('Enter "/" for the home page.') }}
                                </x-form.text>
                            </div>
                        </div>
                        <div class="form-group row required">
                            <label for="language" class="control-label col-form-label text-end col-md-3">
                                {{ __('Language') }}
                            </label>
                            <div class="col-md-2">
                                <select name="language" id="language" class="form-select">
                                    @foreach (LaravelLocalization::getSupportedLocales() as $key => $locale)
                                        <option value="{{ $key }}"{{ old('language') === $key || ($entry && $entry->language === $key) ? ' selected' : ($key === app()->getLocale() ? ' selected' : null) }}>
                                            {{ $locale['native'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="control-label col-form-label text-end col-md-3">
                                {{ __('Description') }}
                            </label>
                            <div class="col-md-9">
                                <input type="text" id="description" class="form-control" name="description"
                                       value="{{ old('description') ?? $entry?->description }}"
                                       aria-describedby="description-help-text">
                                <x-form.text id="description-help-text">
                                    {{ __('Recommended maximum length - 155 characters.') }}
                                </x-form.text>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="og-type" class="control-label col-form-label text-end col-md-3">
                                {{ __('OpenGraph type') }}
                            </label>
                            <div class="col-md-2">
                                <select name="og_type" id="og-type" class="form-select form-control">
                                    <optgroup label="{{ __('Music') }}">
                                        <option value="music.song">{{ __('Song') }}</option>
                                        <option value="music.album">{{ __('Album') }}</option>
                                        <option value="music.playlist">{{ __('Playlist') }}</option>
                                        <option value="music.radio_station">{{ __('Radio station') }}</option>
                                    </optgroup>
                                    <optgroup label="{{ __('Video') }}">
                                        <option value="video.movie">{{ __('Movie') }}</option>
                                        <option value="video.episode">{{ __('Episode') }}</option>
                                        <option value="video.tv_show">{{ __('TV show') }}</option>
                                        <option value="video.other">{{ __('Other') }}</option>
                                    </optgroup>
                                    <option value="article">{{ __('Article') }}</option>
                                    <option value="book">{{ __('Book') }}</option>
                                    <option value="profile">{{ __('Profile') }}</option>
                                    <option value="website">{{ __('Website') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="og-title" class="control-label col-form-label text-end col-md-3">
                                {{ __('OpenGraph title') }}
                            </label>
                            <div class="col-md-9">
                                <input type="text" id="go-title" class="form-control" name="og_title" maxlength="80"
                                       aria-describedby="og-title-help-text"
                                       value="{{ old('og_title') ?? $entry?->og_title }}">
                                <x-form.text id="og-title-help-text">
                                    {{ __('OpenGraph title can differ from a page title.') }}<br>
                                    {{ __('Maximum length is 80 characters, however it is recommended that you keep it under 60 characters.') }}
                                </x-form.text>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="og-image" class="control-label col-form-label text-end col-md-3">
                                {{ __('OpenGraph image') }}
                            </label>
                            <div class="col-md-9">
                                <x-form.input.image name="og_image" :current="$entry?->og_image">
                                    <x-slot:help-text>
                                        {{ __('Allowed file types: jpg, jpeg, png, webp.') }}<br>
                                        {{ __('For og:image , use high-quality images with dimensions of at least 1,200x630 pixels, while keeping the file size under 8 MB.')  }}
                                    </x-slot:help-text>
                                </x-form.input.image>
                            </div>
                        </div>
                    </x-slot:body>

                    <x-slot:footer>
                        <x-form.actions :back="route('admin.seo.list')"/>
                    </x-slot:footer>
                </x-card.card>
            </x-form.form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ vendor('select2/js/select2.full.min.js') }}"></script>
    <script src="{{ vendor('select2/js/i18n/'.(app()->getLocale()).'.js') }}"></script>
    <script>
        function formatLanguage(language) {
            if (!language.id) {
                return language.text;
            }

            let $language = $('<span><span class="flag-icon flag-icon-'
                + language.element.value.toLowerCase() + '"></span>&nbsp;' + language.text + '</span>');

            return $language;
        }

        $(function () {
            $('#language').select2({
                language: '{{ app()->getLocale() }}',
                minimumResultsForSearch: -1,
                templateResult: formatLanguage,
                templateSelection: formatLanguage
            });

            $('#og-type').select2({
                language: '{{ app()->getLocale() }}',
                minimumResultsForSearch: -1
            });

            @if (old('ogType') || isset($entry))
            $('#og-type').val('{{ old('ogType') ?? $entry?->og_type }}').trigger('change');
            @else
            $('#og-type').val('website').trigger('change');
            @endif
        });
    </script>
@endpush
