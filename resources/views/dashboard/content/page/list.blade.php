@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-card.card>
                <x-slot:header>
                    <x-card.tools>
                        <x-card.tools-item class="btn-primary" :route="route('admin.content.page.add')">
                            <i class="fa-duotone fa-plus fa-fw"></i> {{ __('buttons.add') }}
                        </x-card.tools-item>
                    </x-card.tools>
                </x-slot:header>

                <x-slot:body>
                    <div id="app">
                        <pages-table :route-source="'{{ route('admin.content.page.load') }}'"
                                       :route-edit="'{{ route('admin.content.page.edit', ['id' => ':id']) }}'"
                                       :route-translate="'{{ route('admin.content.page.translate', ['id' => ':id']) }}'"
                                       :route-delete="'{{ route('admin.content.page.delete') }}'"></pages-table>
                    </div>
                </x-slot:body>
            </x-card.card>
        </div>
    </div>
@endsection
