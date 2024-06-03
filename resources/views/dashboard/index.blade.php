@extends('dashboard.layout')

@section('content')
    <div class="row">
        @if ($shortcuts->isNotEmpty())
            @foreach ($shortcuts as $shortcut)
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box dashboard-shortcut">
                        <span class="info-box-icon text-bg-primary shadow-sm">
                            <i class="fa-duotone fa-bookmark"></i>
                        </span>
                        <div class="info-box-content">
                            <a href="{{ $shortcut->href }}" class="info-box-text">
                                {!! $shortcut->shortcut_name !!}
                            </a>
                        </div>
                        <button class="btn-close" type="button" data-id="{{ $shortcut->id }}"></button>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
