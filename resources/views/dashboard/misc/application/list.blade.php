@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-card.card>
                <x-slot:body>
                    <div id="app">
                        <applications-table :route-source="'{{ route('admin.application.load') }}'"
                                       :route-delete="'{{ route('admin.application.delete') }}'"></applications-table>
                    </div>
                </x-slot:body>
            </x-card.card>
        </div>
    </div>
@endsection
