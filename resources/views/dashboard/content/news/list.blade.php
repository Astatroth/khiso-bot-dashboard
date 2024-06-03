@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-card.card>
                <x-slot:header>
                    <x-card.tools>
                        <x-card.tools-item class="btn-primary" :route="route('admin.content.news.add')">
                            <i class="fa-duotone fa-plus fa-fw"></i> {{ __('buttons.add') }}
                        </x-card.tools-item>
                    </x-card.tools>
                </x-slot:header>

                <x-slot:body>
                    <div id="app">
                        <news-table :route-source="'{{ route('admin.content.news.load') }}'"
                                       :route-edit="'{{ route('admin.content.news.edit', ['id' => ':id']) }}'"
                                       :route-translate="'{{ route('admin.content.news.translate', ['id' => ':id']) }}'"
                                       :route-delete="'{{ route('admin.content.news.delete') }}'"></news-table>
                    </div>
                </x-slot:body>
            </x-card.card>
        </div>
    </div>
@endsection
