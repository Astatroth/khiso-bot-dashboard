@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-form.form :action="route('admin.content.team.save')" :files="true">
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
                            <x-form.label for="name" class="col-md-3">
                                {{ __('Name') }}
                            </x-form.label>
                            <div class="col-md-9">
                                <input type="text" name="name" id="name" class="form-control"
                                       value="{{ old('name') ?? $entry?->name }}" maxlength="255">
                            </div>
                        </div>

                        <div class="form-group row required">
                            <x-form.label for="position" class="col-md-3">
                                {{ __('Position') }}
                            </x-form.label>
                            <div class="col-md-9">
                                <input type="text" name="position" id="position" class="form-control"
                                       value="{{ old('position') ?? $entry?->position }}" maxlength="255">
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
                    </x-slot:body>

                    <x-slot:footer>
                        <x-form.actions :back="route('admin.content.team.list')"/>
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

