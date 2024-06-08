@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-form.form :action="route('admin.channels.save')">
                @isset($entry?->id)
                    <input type="hidden" name="id" value="{{ $entry->id }}">
                @endisset

                <x-card.card>
                    <x-slot:body>
                        <div class="form-group row required">
                            <x-form.label for="title" class="col-md-3">
                                {{ __('Title') }}
                            </x-form.label>
                            <div class="col-md-9">
                                <input type="text" name="title" id="title" class="form-control"
                                       value="{{ old('title') ?? $entry?->title }}" max="255" required>
                            </div>
                        </div>

                        <div class="form-group row required">
                            <x-form.label for="url" class="col-md-3">
                                {{ __('URL') }}
                            </x-form.label>
                            <div class="col-md-9">
                                <input type="text" name="url" id="url" class="form-control"
                                       value="{{ old('url') ?? $entry?->url }}" max="255" required
                                       placeholder="https://t.me/@some_channel_name">
                            </div>
                        </div>

                        <div class="form-group row required">
                            <x-form.label for="channel_id" class="col-md-3">
                                {{ __('Channel ID') }}
                            </x-form.label>
                            <div class="col-md-9">
                                <input type="text" name="channel_id" id="channel_id" class="form-control"
                                       value="{{ old('channel_id') ?? $entry?->channel_id }}" required
                                       placeholder="-100xxxxxxxxx...">
                                <x-form.text>
                                    {!! __('You can discover the channel ID by using :anchor_open@username_to_id_bot:anchor_close.', ['anchor_open' => '<a href="https://t.me/username_to_id_bot" target="_blank">', 'anchor_close' => '</a>']) !!}
                                </x-form.text>
                            </div>
                        </div>
                    </x-slot:body>

                    <x-slot:footer>
                        <x-form.actions :back="route('admin.channels.list')"/>
                    </x-slot:footer>
                </x-card.card>
            </x-form.form>
        </div>
    </div>
@endsection
