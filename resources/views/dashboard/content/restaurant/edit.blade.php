@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-form.form :action="route('admin.content.restaurant.save')" :files="true">
                @isset($entry?->id)
                    <input type="hidden" name="id" value="{{ $entry->id }}">
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
                                <a class="nav-link" href="#socials" data-bs-toggle="tab">
                                    {{ __('Socials') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#location" data-bs-toggle="tab">
                                    {{ __('Location') }} *
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

                                <div class="form-group row">
                                    <x-form.label for="description" class="col-md-3">
                                        {{ __('Description') }}
                                    </x-form.label>
                                    <div class="col-md-9">
                                        <textarea name="description" id="description" cols="30" rows="10"
                                                  class="form-control">{{ old('description') ?? $entry?->description }}</textarea>
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

                                <div class="form-group row{{ is_null($entry) ? ' required' : '' }}">
                                    <x-form.label for="logo" class="col-md-3">
                                        {{ __('Logo') }}
                                    </x-form.label>
                                    <div class="col-md-9">
                                        <x-form.input.image name="logo" :current="$entry?->logo" :currentName="'current_logo'">
                                            <x-slot:help-text>
                                                {{ __('Allowed file types: jpg, jpeg, png, webp.') }}<br>
                                                {{ __('Maximum size: 5 MB.') }}
                                            </x-slot:help-text>
                                        </x-form.input.image>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <x-form.label for="certificate" class="col-md-3">
                                        {{ __('Certificate') }}
                                    </x-form.label>
                                    <div class="col-md-9">
                                        <x-form.input.file :accept="'application/pdf'" name="certificate" :current="$entry?->certificate">
                                            <x-slot:help-text>
                                                {{ __('Allowed file types: pdf.') }}<br>
                                                {{ __('Maximum size: 5 MB.') }}
                                            </x-slot:help-text>
                                        </x-form.input.file>
                                    </div>
                                </div>
                            </div>

                            <!-- Socials -->
                            <div class="tab-pane" id="socials">
                                <div class="form-group row">
                                    <x-form.label for="instagram-url" class="col-md-3">
                                        {{ __('Instagram') }}
                                    </x-form.label>
                                    <div class="col-md-9">
                                        <input type="url" name="instagram_url" id="instagram-url" class="form-control"
                                               value="{{ old('instagram_url') ?? $entry?->instagram_url }}"
                                               maxlength="255" placeholder="https://instagram.com/...">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <x-form.label for="facebook-url" class="col-md-3">
                                        {{ __('Facebook') }}
                                    </x-form.label>
                                    <div class="col-md-9">
                                        <input type="url" name="facebook_url" id="facebook-url" class="form-control"
                                               value="{{ old('facebook_url') ?? $entry?->facebook_url }}"
                                               maxlength="255" placeholder="https://facebook.com/...">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <x-form.label for="telegram-url" class="col-md-3">
                                        {{ __('Telegram') }}
                                    </x-form.label>
                                    <div class="col-md-9">
                                        <input type="url" name="telegram_url" id="telegram-url" class="form-control"
                                               value="{{ old('telegram_url') ?? $entry?->telegram_url }}"
                                               maxlength="255" placeholder="https://tg.me/...">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <x-form.label for="website-url" class="col-md-3">
                                        {{ __('Website') }}
                                    </x-form.label>
                                    <div class="col-md-9">
                                        <input type="url" name="website_url" id="website-url" class="form-control"
                                               value="{{ old('website_url') ?? $entry?->website_url }}"
                                               maxlength="255" placeholder="https://...">
                                    </div>
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="tab-pane" id="location">
                                <div class="form-group row">
                                    <x-form.label for="country" class="col-md-3">
                                        {{ __('Country') }}
                                    </x-form.label>
                                    <div class="col-md-3">
                                        <select name="country" id="country" class="form-select">
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"{{ old('country') === $country->id || $entry?->country_id === $country->id ? ' selected' : ($country->name === 'Uzbekistan' ? ' selected' : '') }}>
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row required">
                                    <x-form.label class="col-md-3">
                                        {{ __('Location') }}
                                        <x-form.text class="d-block">
                                            {{ __('Click on a map to pin the location.') }}
                                        </x-form.text>
                                    </x-form.label>
                                    <div class="col-md-9">
                                        <div id="map" style="width: 100%; height: 600px;"></div>
                                    </div>
                                    <input type="hidden" name="latitude"
                                           value="{{ old('latitude') ?? ($entry?->latutde ?? '41.313741') }}">
                                    <input type="hidden" name="longitude"
                                           value="{{ old('longitude') ?? ($entry?->longitude ?? '69.253398') }}">
                                </div>
                            </div>
                        </div>
                    </x-slot:body>

                    <x-slot:footer>
                        <x-form.actions :back="route('admin.content.restaurant.list')"/>
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
    <script src="{{ vendor('select2/js/select2.full.min.js') }}"></script>
    <script src="{{ vendor('select2/js/i18n/'.(app()->getLocale()).'.js') }}"></script>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=ce8f27db-6bab-46ee-a35f-e05b1e0ce00a&lang=ru_RU"
            type="text/javascript"></script>
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

            ymaps.ready(init);

            function init() {
                var map = new ymaps.Map("map", {
                    center: [{{ $entry?->latitude ?? '41.313741' }}, {{ $entry?->longitude ?? '69.253398' }}],
                    zoom: 15,
                    controls: ['zoomControl']
                });

                @if (isset($entry) && $entry->latitude && $entry->longitude)
                map.geoObjects.add(new ymaps.Placemark([
                    {{ $entry->latitude }}, {{ $entry->longitude }}
                ]));
                @endif

                map.events.add('click', function (e) {
                    if (!map.balloon.isOpen()) {
                        var coords = e.get('coords');
                        toastr.info('<p>{{ __('You have selected the following coordinates:') }}</p>' +
                            '<p>' + [
                                        coords[0].toPrecision(6),
                                        coords[1].toPrecision(6)
                                    ].join(', ') + '</p>' +
                            '<p>{{ __('Click the "Save" button to save the selected coordinates, or click on the map to select different ones.') }}</p>');
                        map.geoObjects.removeAll();
                        map.geoObjects.add(new ymaps.Placemark([coords[0].toPrecision(6), coords[1].toPrecision(6)]));
                        $('input[name=latitude]').val(coords[0].toPrecision(6));
                        $('input[name=longitude]').val(coords[1].toPrecision(6));
                    } else {
                        map.balloon.close();
                        $('input[name=latitude]').val();
                        $('input[name=longitude]').val();
                    }
                });
            }
        });
    </script>
@endpush
