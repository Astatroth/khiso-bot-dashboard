@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-card.card>
                <x-slot:header>
                    <x-card.tools>
                        <x-card.tools-item class="btn-primary" :route="route('admin.olympiad.add')">
                            <i class="fa-duotone fa-plus fa-fw"></i> {{ __('buttons.add') }}
                        </x-card.tools-item>
                    </x-card.tools>
                </x-slot:header>

                <x-slot:body>
                    <div id="app">
                        <olympiads-table :route-source="'{{ route('admin.olympiad.load') }}'"
                                    :route-edit="'{{ route('admin.olympiad.edit', ['id' => ':id']) }}'"
                                    :route-delete="'{{ route('admin.olympiad.delete') }}'"
                                    :statuses="{{ json_encode($statuses) }}"></olympiads-table>
                    </div>
                </x-slot:body>
            </x-card.card>
        </div>
    </div>
@endsection
