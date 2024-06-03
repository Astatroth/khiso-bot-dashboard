@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-form.form :action="route('admin.content.representative.save')" :files="true">
                @isset($entry?->id)
                    <input type="hidden" name="id" value="{{ $entry->id }}">
                @endisset

                <x-card.card>
                    <x-slot:body>
                        <div class="form-group row required">
                            <x-form.label for="country_name" class="col-md-3">
                                {{ __('Country name') }}
                            </x-form.label>
                            <div class="col-md-9">
                                <input type="text" name="country_name" id="country_name" class="form-control"
                                       value="{{ old('country_name') ?? $entry?->name }}" maxlength="255">
                            </div>
                        </div>

                        <div class="form-group row{{ is_null($entry) ? ' required' : '' }}">
                            <x-form.label for="flag" class="col-md-3">
                                {{ __('Flag') }}
                            </x-form.label>
                            <div class="col-md-9">
                                <x-form.input.image name="flag" :current="$entry?->flag">
                                    <x-slot:help-text>
                                        {{ __('Allowed file types: jpg, jpeg, png, webp.') }}<br>
                                        {{ __('Maximum size: 5 MB.') }}
                                    </x-slot:help-text>
                                </x-form.input.image>
                            </div>
                        </div>

                        <div class="form-group row">
                            <x-form.label for="pdf" class="col-md-3">
                                {{ __('PDF') }}
                            </x-form.label>
                            <div class="col-md-9">
                                <x-form.input.file :accept="'application/pdf'" name="pdf" :current="$entry?->pdf">
                                    <x-slot:help-text>
                                        {{ __('Allowed file types: pdf.') }}<br>
                                        {{ __('Maximum size: 5 MB.') }}
                                    </x-slot:help-text>
                                </x-form.input.file>
                            </div>
                        </div>
                    </x-slot:body>

                    <x-slot:footer>
                        <x-form.actions :back="route('admin.content.representative.list')"/>
                    </x-slot:footer>
                </x-card.card>
            </x-form.form>
        </div>
    </div>
@endsection
