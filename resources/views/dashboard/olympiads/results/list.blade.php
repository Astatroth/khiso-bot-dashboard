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
                        <a class="btn btn-sm btn-primary" href="{{ route('admin.olympiad.result.export', $olympiadId) }}">
                            <i class="fa-duotone fa-file-download fa-fw"></i>
                            {{ __('buttons.export')}}
                        </a>
                    </x-card.tools>
                </x-slot:header>

                <x-slot:body>
                    <div id="app">
                        <results-table :route-source="'{{ route('admin.olympiad.result.load') }}'"
                                       :olympiad-id="{{ $olympiadId }}"
                                       :route-view="'{{ route('admin.olympiad.result.view', ['id' => $olympiadId, 'result_id' => ':id']) }}'"></results-table>
                    </div>
                </x-slot:body>
            </x-card.card>
        </div>
    </div>
@endsection
