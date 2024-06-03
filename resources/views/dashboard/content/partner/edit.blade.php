@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-form.form :action="route('admin.content.partner.save')" :files="true">
                @isset($entry?->id)
                    <input type="hidden" name="id" value="{{ $entry->id }}">
                @endisset

                <x-card.card>
                    <x-slot:body>
                        <div class="form-group row required">
                            <x-form.label for="partner_name" class="col-md-3">
                                {{ __('Partner name') }}
                            </x-form.label>
                            <div class="col-md-9">
                                <input type="text" name="partner_name" id="partner_name" class="form-control"
                                       value="{{ old('partner_name') ?? $entry?->name }}" maxlength="255">
                            </div>
                        </div>

                        <div class="form-group row{{ is_null($entry) ? ' required' : '' }}">
                            <x-form.label for="logo" class="col-md-3">
                                {{ __('Logo') }}
                            </x-form.label>
                            <div class="col-md-9">
                                <x-form.input.image name="logo" :current="$entry?->logo">
                                    <x-slot:help-text>
                                        {{ __('Allowed file types: jpg, jpeg, png, webp.') }}<br>
                                        {{ __('Maximum size: 5 MB.') }}
                                    </x-slot:help-text>
                                </x-form.input.image>
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
                    </x-slot:body>

                    <x-slot:footer>
                        <x-form.actions :back="route('admin.content.partner.list')"/>
                    </x-slot:footer>
                </x-card.card>
            </x-form.form>
        </div>
    </div>
@endsection
