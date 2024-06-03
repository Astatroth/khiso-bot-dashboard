@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-card.card>
                <x-slot:header>
                    <x-card.tools>
                        <x-card.tools-item class="btn-primary" :route="route('admin.content.banner.add')">
                            <i class="fa-duotone fa-plus fa-fw"></i> {{ __('buttons.add') }}
                        </x-card.tools-item>
                    </x-card.tools>
                </x-slot:header>

                <x-slot:body>
                    <div id="app">
                        <banners-table :route-source="'{{ route('admin.content.banner.load') }}'"
                                    :route-edit="'{{ route('admin.content.banner.edit', ['id' => ':id']) }}'"
                                    :route-translate="'{{ route('admin.content.banner.translate', ['id' => ':id']) }}'"
                                    :route-delete="'{{ route('admin.content.banner.delete') }}'"></banners-table>
                    </div>
                </x-slot:body>
            </x-card.card>
        </div>
    </div>
@endsection
