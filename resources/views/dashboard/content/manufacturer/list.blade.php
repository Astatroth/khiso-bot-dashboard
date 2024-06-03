@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-card.card>
                <x-slot:header>
                    <x-card.tools>
                        <x-card.tools-item class="btn-primary" :route="route('admin.content.manufacturer.add')">
                            <i class="fa-duotone fa-plus fa-fw"></i> {{ __('buttons.add') }}
                        </x-card.tools-item>
                    </x-card.tools>
                </x-slot:header>

                <x-slot:body>
                    <div id="app">
                        <manufacturers-table :route-source="'{{ route('admin.content.manufacturer.load') }}'"
                                       :route-edit="'{{ route('admin.content.manufacturer.edit', ['id' => ':id']) }}'"
                                       :route-delete="'{{ route('admin.content.manufacturer.delete') }}'"></manufacturers-table>
                    </div>
                </x-slot:body>
            </x-card.card>
        </div>
    </div>
@endsection
