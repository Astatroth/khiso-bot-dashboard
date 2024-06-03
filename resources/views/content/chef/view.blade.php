@extends('layouts.app')

@section('content')
    <section class="strange-cards-section" id="strange-cards-section">
        <div class="container">
            <div class="restaurants-txt-content">
                <span class="title-restaurants">
                    {{ __('Halal chefs') }}
                </span>
                <p class="restaurants-txt">
                    {{ __('This section is dedicated to famous Chefs who received the International Halal Chef Badge') }}
                </p>
            </div>
            <div class="strange-cards-main">
                @foreach ($chefs as $chef)
                    <div class="strange-card">
                        <img src="{{ $chef->photo->url }}" alt="{{ $chef->name }}">
                        <div class="strange-card-inner">
                            <span class="strange-card-inner-txt">
                                {{ $chef->name }}
                            </span>
                            <div class="restaurants-icons">
                                @isset($chef->instagram_url)
                                    <a class="app-icon-btn-secondary" href="{{ $chef->instagram_url }}" target="_blank">
                                        <img src="{{ asset('img/instagram.svg') }}" alt="Instagram">
                                    </a>
                                @endisset
                                @isset($chef->instagram_url)
                                    <a class="app-icon-btn-secondary" href="{{ $chef->facebook_url }}" target="_blank">
                                        <img src="{{ asset('img/facebook.svg') }}" alt="Facebook">
                                    </a>
                                @endisset
                                @isset($chef->telegram_url)
                                    <a class="app-icon-btn-secondary" href="{{ $chef->facebook_url }}" target="_blank">
                                        <img src="{{ asset('img/telegram.svg') }}" alt="Telegram">
                                    </a>
                                @endisset
                            </div>
                            <button class="blue-button  blue-button-secondary click-here">
                                <a href="{{ $chef->certificate->url }}" target="_blank">
                                    {{ __('View certificate') }}
                                </a>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
