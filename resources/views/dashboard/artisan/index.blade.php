@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-card.card>
                <x-slot:body>
                    <div id="app">
                        <artisan-ui :commands="{{ json_encode(!empty($commands) ? $commands : (object)[]) }}"
                                    :route-execute="'{{ route('admin.artisan.execute') }}'"/>
                    </div>
                </x-slot:body>
            </x-card.card>
        </div>
    </div>
@endsection
