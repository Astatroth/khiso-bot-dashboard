@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-form.form :action="route('admin.content.chef.save')" :files="true">
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
                            <x-form.label for="name" class="col-md-3">
                                {{ __('Name') }}
                            </x-form.label>
                            <div class="col-md-9">
                                <input type="text" name="chef_name" id="name" class="form-control"
                                       value="{{ old('chef_name') ?? $entry?->name }}" maxlength="255">
                            </div>
                        </div>

                        <div class="form-group row{{ is_null($entry) ? ' required' : '' }}">
                            <x-form.label for="image" class="col-md-3">
                                {{ __('Photo') }}
                            </x-form.label>
                            <div class="col-md-9">
                                <x-form.input.image name="photo" :current="$entry?->photo">
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
                    </x-slot:body>

                    <x-slot:footer>
                        <x-form.actions :back="route('admin.content.chef.list')"/>
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
        });
    </script>
@endpush
