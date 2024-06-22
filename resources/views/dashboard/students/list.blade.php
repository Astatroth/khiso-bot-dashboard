@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-card.card>
                <x-slot:header>
                    <x-card.tools>
                        <a class="btn btn-sm btn-primary" href="{{ route('admin.student.export') }}">
                            <i class="fa-duotone fa-file-download fa-fw"></i>
                            {{ __('buttons.export')}}
                        </a>
                    </x-card.tools>
                </x-slot:header>

                <x-slot:body>
                    <div id="app">
                        <students-table :route-source="'{{ route('admin.student.load') }}'"
                                        :route-resend="'{{ route('admin.olympiad.button.resend') }}'"></students-table>
                    </div>
                </x-slot:body>
            </x-card.card>
        </div>
    </div>
@endsection
