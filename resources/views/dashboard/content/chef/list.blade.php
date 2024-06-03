@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-card.card>
                <x-slot:header>
                    <x-card.tools>
                        <x-card.tools-item class="btn-primary" :route="route('admin.content.chef.add')">
                            <i class="fa-duotone fa-plus fa-fw"></i> {{ __('buttons.add') }}
                        </x-card.tools-item>
                    </x-card.tools>
                </x-slot:header>

                <x-slot:body>
                    <div id="app">
                        <chefs-table :route-source="'{{ route('admin.content.chef.load') }}'"
                                     :route-edit="'{{ route('admin.content.chef.edit', ['id' => ':id']) }}'"
                                     :route-translate="'{{ route('admin.content.chef.translate', ['id' => ':id']) }}'"
                                     :route-delete="'{{ route('admin.content.chef.delete') }}'"
                                     :countries="{{ $countries }}"></chefs-table>
                    </div>
                </x-slot:body>
            </x-card.card>
        </div>
    </div>
@endsection
