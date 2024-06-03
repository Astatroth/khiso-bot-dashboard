@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-card.card>
                <x-slot:header>
                    <x-card.tools>
                        <x-card.tools-item class="btn-primary" :route="route('admin.structure.block.add')">
                            <i class="fa-duotone fa-plus fa-fw"></i> {{ __('buttons.add') }}
                        </x-card.tools-item>
                    </x-card.tools>
                </x-slot:header>

                <x-slot:body>
                    <div id="app">
                        <blocks-table :route-source="'{{ route('admin.structure.block.load') }}'"
                                     :route-edit="'{{ route('admin.structure.block.edit', ['id' => ':id']) }}'"
                                     :route-translate="'{{ route('admin.structure.block.translate', ['id' => ':id']) }}'"
                                     :route-delete="'{{ route('admin.structure.block.delete') }}'"></blocks-table>
                    </div>
                </x-slot:body>
            </x-card.card>
        </div>
    </div>
@endsection
