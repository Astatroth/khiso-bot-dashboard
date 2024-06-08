@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-card.card>
                <x-slot:header>
                    <x-card.tools>
                        <x-card.tools-item class="btn-primary" :route="route('admin.channels.add')">
                            <i class="fa-duotone fa-plus fa-fw"></i> {{ __('buttons.add') }}
                        </x-card.tools-item>
                    </x-card.tools>
                </x-slot:header>

                <x-slot:body>
                    <div id="app">
                        <telegram-channels-table :route-source="'{{ route('admin.channels.load') }}'"
                                   :route-edit="'{{ route('admin.channels.edit', ['id' => ':id']) }}'"
                                   :route-delete="'{{ route('admin.channels.delete') }}'"></telegram-channels-table>
                    </div>
                </x-slot:body>
            </x-card.card>
        </div>
    </div>
@endsection
