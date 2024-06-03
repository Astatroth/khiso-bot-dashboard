@extends('layouts.app')

@section('content')
    <section class="about-us-section">
        <div class="container">
            <span class="title-restaurants">
                {{ __('About us') }}
            </span>

            {!! render_block('about-page') !!}

            @if (isset($team) && $team->isNotEmpty())
            <div class="personal-contents">
                <p class="personal-title">
                    {{ __('Our team') }}
                </p>
                <div class="personal-information-wrapper">
                    @foreach ($team as $item)
                        <div class="personal-info-card">
                            <div class="personal-img">
                                <img src="{{ $item->photo->url }}" alt="{{ $item->name }}">
                            </div>
                            <h3 class="personal-name">{{ $item->name }}</h3>
                            <p class="personal-info">
                                {{ $item->position }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>
@endsection
