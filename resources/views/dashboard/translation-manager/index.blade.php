@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-card.card>
                <x-slot:body>
                    <div id="app">
                        <translation-manager :route-import="'{{ route('admin.translation.import') }}'"
                                             :route-discover="'{{ route('admin.translation.discover') }}'"
                                             :route-load="'{{ route('admin.translation.load') }}'"
                                             :route-group-load="'{{ route('admin.translation.group.load') }}'"
                                             :route-save="'{{ route('admin.translation.save') }}'"
                                             :route-publish="'{{ route('admin.translation.publish') }}'"/>
                    </div>
                </x-slot:body>
            </x-card.card>
        </div>
    </div>
@endsection
