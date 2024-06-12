@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-card.card>
                <x-slot:header>
                    <div class="card-title">
                        <a class="btn btn-sm btn-secondary" href="{{ route('admin.olympiad.list') }}">
                            < {{ __('Back to olympiads list') }}
                        </a>
                    </div>
                    <x-card.tools>
                        <a class="btn btn-sm btn-primary" href="{{ route('admin.olympiad.question.add', $olympiad->id) }}">
                            <i class="fa-duotone fa-plus fa-fw"></i>
                            {{ __('buttons.add')}}
                        </a>
                    </x-card.tools>
                </x-slot:header>

                <x-slot:body>
                    <div id="app">
                        <questions-table :route-source="'{{ route('admin.olympiad.question.load') }}'"
                                         :olympiad-id="{{ $olympiad->id }}"
                                         :route-edit="'{{ route('admin.olympiad.question.edit', ['olympiad_id' => ':olympiad', 'id' => ':id']) }}'"
                                         :route-delete="'{{ route('admin.olympiad.question.delete') }}'"
                        ></questions-table>
                    </div>
                </x-slot:body>
            </x-card.card>
        </div>
    </div>
@endsection
