@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-card.card>
                <x-slot:header>
                    <x-card.tools>
                        <x-card.tools-item class="btn-primary" :route="route('admin.seo.add')">
                            <i class="fa-duotone fa-plus fa-fw"></i> {{ __('buttons.add') }}
                        </x-card.tools-item>
                    </x-card.tools>
                </x-slot:header>

                <x-slot:body>
                    <div id="app">
                        <seo-table :route-source="'{{ route('admin.seo.load') }}'"
                                   :route-edit="'{{ route('admin.seo.edit', ['id' => ':id']) }}'"
                                   :route-delete="'{{ route('admin.seo.delete') }}'"></seo-table>
                    </div>
                </x-slot:body>
            </x-card.card>
        </div>
    </div>
@endsection
