@extends('layouts.app')

@section('content')
    <section class="restaurants-section" id="restaurants-section">
        <div class="container">
            <div class="restaurants-txt-content">
                <span class="title-restaurants">{{ __('Halal restaurants') }}</span>
                <p class="restaurants-txt">
                    {{ __('In this section you can get acquainted with catering establishments that have been awarded the Halal Certificate') }}
                </p>
            </div>

            <div class="restaurants-cards-wrapper">
                @foreach ($restaurants as $item)
                    <div class="restaurants-cards">
                        <div class="image-content">
                            <img src="{{ $item->image->url }}" alt="{{ $item->title }}">
                            <div class="secondary-image">
                                <img src="{{ $item->logo->url }}" alt="{{ $item->title }}">
                            </div>
                        </div>
                        <div class="restaurants-card-inner">
                            <h1 class="restaurants-title">
                                {{ $item->title }}
                            </h1>
                            <p class="restaurants-card-txt">
                                {{ $item->description }}
                            </p>
                            @isset($item->certificate)
                                <button class="blue-button click-here">
                                    <a href="{{ $item->certificate->url }}" target="_blank">
                                        {{ __('View certificate') }}
                                    </a>
                                </button>
                            @endisset
                            <div class="restaurants-icons">
                                @isset($item->instagram_url)
                                    <a class="app-icon-btn" href="{{ $item->instagram_url }}" target="_blank">
                                        <img src="{{ asset('img/instagram.png') }}" alt="Instagram">
                                    </a>
                                @endisset
                                @isset($item->instagram_url)
                                    <a class="app-icon-btn" href="{{ $item->facebook_url }}" target="_blank">
                                        <img src="{{ asset('img/facebook.png') }}" alt="Facebook">
                                    </a>
                                @endisset
                                @isset($item->telegram_url)
                                    <a class="app-icon-btn" href="{{ $item->facebook_url }}" target="_blank">
                                        <img src="{{ asset('img/telegram.png') }}" alt="Telegram">
                                    </a>
                                @endisset
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="banner-content-btn-block">
                <button class="banner-content-btn" style="text-transform: uppercase; font-weight: bold;">
                    <a href="{{ route('restaurant.country.list') }}">
                        {{ __('Back to countries') }}
                    </a>
                </button>
            </div>
        </div>
    </section>
@endsection
