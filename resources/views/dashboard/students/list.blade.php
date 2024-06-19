@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-card.card>
                <x-slot:body>
                    <div id="app">
                        <students-table :route-source="'{{ route('admin.student.load') }}'"></students-table>
                    </div>
                </x-slot:body>
            </x-card.card>
        </div>
    </div>
@endsection