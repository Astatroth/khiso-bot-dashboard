@extends('layouts.app')

@section('content')
    @if ($banners->isNotEmpty())
        <section class="banner-section">
            <div class="swiper bannerSwiper">
                <div class="swiper-wrapper">
                    @foreach ($banners as $banner)
                        <div class="swiper-slide banner-content-card">
                            <div class="banner-img">
                                <img src="{{ $banner->image->url }}" alt="{{ $banner->title }}">
                            </div>
                            <div class="container">
                                <div class="banner-innerside">
                                    <div class="banner-content">
                                        {!! $banner->description !!}
                                        @if ($banner->link)
                                            <a href="{{ $banner->link }}" class="banner-content-btn">
                                                {{ $banner->link_label ?? __('Read more') }}
                                            </a>
                                        @endif
                                    </div>
                                    <div class="header-address-card">
                                        <div></div>
                                        <div>
                                            @if ($banner->location_name)
                                                <div class="header-address">
                                                    {{ $banner->location_name }}
                                                </div>
                                            @endif

                                            @if ($banner->location_location)
                                                <div class="tashkent">
                                                    <i class="fas fa-location-dot"></i>{{ $banner->location_location }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($restaurants->isNotEmpty())
        <section class="restaurants-section" id="restaurants-section">
            <div class="container">
                <div class="restaurants-txt-content">
                    {!! render_block('restaurants-header') !!}
                </div>

                <div class="restaurants-cards-wrapper">
                    <div class="restaurants-cards">
                        <div class="image-content">
                            <img src="{{ $restaurants[0]->image->url }}" alt="{{ $restaurants[0]->title }}">
                            @isset($restaurants[0]->logo)
                                <div class="secondary-image">
                                    <img src="{{ $restaurants[0]->logo->url }}" alt="{{ $restaurants[0]->title }}">
                                </div>
                            @endisset
                        </div>
                        <div class="restaurants-card-inner">
                            <h1 class="restaurants-title">
                                {{ $restaurants[0]->title }}
                            </h1>
                            <p class="restaurants-card-txt">
                                {{ $restaurants[0]->description }}
                            </p>
                            @isset($restaurants[0]->certificate)
                                <a class="blue-button click-here" href="{{ $restaurants[0]->certificate->url }}" target="_blank">
                                    {{ __('View certificate') }}
                                </a>
                            @endisset
                            <div class="restaurants-icons">
                                @isset($restaurants[0]->instagram_url)
                                    <a class="app-icon-btn" href="{{ $restaurants[0]->instagram_url }}" target="_blank">
                                        <img src="{{ asset('img/instagram.png') }}" alt="Instagram">
                                    </a>
                                @endisset
                                @isset($restaurants[0]->instagram_url)
                                    <a class="app-icon-btn" href="{{ $restaurants[0]->facebook_url }}" target="_blank">
                                        <img src="{{ asset('img/facebook.png') }}" alt="Facebook">
                                    </a>
                                @endisset
                                @isset($restaurants[0]->telegram_url)
                                    <a class="app-icon-btn" href="{{ $restaurants[0]->facebook_url }}" target="_blank">
                                        <img src="{{ asset('img/telegram.png') }}" alt="Telegram">
                                    </a>
                                @endisset
                            </div>
                        </div>
                    </div>
                    @isset($restaurants[1])
                        <div class="restaurants-cards">
                            <div class="image-content">
                                <img src="{{ $restaurants[1]->image->url }}" alt="{{ $restaurants[1]->title }}">
                                @isset($restaurants[1]->logo)
                                    <div class="secondary-image">
                                        <img src="{{ $restaurants[1]->logo->url }}" alt="{{ $restaurants[1]->title }}">
                                    </div>
                                @endisset
                            </div>
                            <div class="restaurants-card-inner">
                                <h1 class="restaurants-title">
                                    {{ $restaurants[1]->title }}
                                </h1>
                                <p class="restaurants-card-txt">
                                    {{ $restaurants[1]->description }}
                                </p>
                                @isset($restaurants[1]->certificate)
                                    <a class="blue-button click-here" href="{{ $restaurants[1]->certificate->url }}" target="_blank">
                                        {{ __('View certificate') }}
                                    </a>
                                @endisset
                                <div class="restaurants-icons">
                                    @isset($restaurants[1]->instagram_url)
                                        <a class="app-icon-btn" href="{{ $restaurants[1]->instagram_url }}" target="_blank">
                                            <img src="{{ asset('img/instagram.png') }}" alt="Instagram">
                                        </a>
                                    @endisset
                                    @isset($restaurants[1]->instagram_url)
                                        <a class="app-icon-btn" href="{{ $restaurants[1]->facebook_url }}" target="_blank">
                                            <img src="{{ asset('img/facebook.png') }}" alt="Facebook">
                                        </a>
                                    @endisset
                                    @isset($restaurants[1]->telegram_url)
                                        <a class="app-icon-btn" href="{{ $restaurants[1]->facebook_url }}" target="_blank">
                                            <img src="{{ asset('img/telegram.png') }}" alt="Telegram">
                                        </a>
                                    @endisset
                                </div>
                            </div>
                        </div>
                    @endisset
                </div>
                <div class="restaurants-cards-wrapper">
                    @isset($restaurants[2])
                        <div class="restaurants-cards">
                            <div class="image-content">
                                <img src="{{ $restaurants[2]->image->url }}" alt="{{ $restaurants[2]->title }}">
                                @isset($restaurants[2]->logo)
                                    <div class="secondary-image">
                                        <img src="{{ $restaurants[2]->logo->url }}" alt="{{ $restaurants[2]->title }}">
                                    </div>
                                @endisset
                            </div>
                            <div class="restaurants-card-inner">
                                <h1 class="restaurants-title">
                                    {{ $restaurants[2]->title }}
                                </h1>
                                <p class="restaurants-card-txt">
                                    {{ $restaurants[2]->description }}
                                </p>
                                @isset($restaurants[2]->certificate)
                                    <a class="blue-button click-here" href="{{ $restaurants[2]->certificate->url }}" target="_blank">
                                        {{ __('View certificate') }}
                                    </a>
                                @endisset
                                <div class="restaurants-icons">
                                    @isset($restaurants[2]->instagram_url)
                                        <a class="app-icon-btn" href="{{ $restaurants[2]->instagram_url }}" target="_blank">
                                            <img src="{{ asset('img/instagram.png') }}" alt="Instagram">
                                        </a>
                                    @endisset
                                    @isset($restaurants[2]->instagram_url)
                                        <a class="app-icon-btn" href="{{ $restaurants[2]->facebook_url }}" target="_blank">
                                            <img src="{{ asset('img/facebook.png') }}" alt="Facebook">
                                        </a>
                                    @endisset
                                    @isset($restaurants[2]->telegram_url)
                                        <a class="app-icon-btn" href="{{ $restaurants[2]->facebook_url }}" target="_blank">
                                            <img src="{{ asset('img/telegram.png') }}" alt="Telegram">
                                        </a>
                                    @endisset
                                </div>
                            </div>
                        </div>
                    @endisset
                    @isset($restaurants[3])
                        <div class="restaurants-cards">
                            <div class="image-content">
                                <img src="{{ $restaurants[3]->image->url }}" alt="{{ $restaurants[3]->title }}">
                                @isset($restaurants[3]->logo)
                                    <div class="secondary-image">
                                        <img src="{{ $restaurants[3]->logo->url }}" alt="{{ $restaurants[3]->title }}">
                                    </div>
                                @endisset
                            </div>
                            <div class="restaurants-card-inner">
                                <h1 class="restaurants-title">
                                    {{ $restaurants[3]->title }}
                                </h1>
                                <p class="restaurants-card-txt">
                                    {{ $restaurants[3]->description }}
                                </p>
                                @isset($restaurants[3]->certificate)
                                    <a class="blue-button click-here" href="{{ $restaurants[3]->certificate->url }}" target="_blank">
                                        {{ __('View certificate') }}
                                    </a>
                                @endisset
                                <div class="restaurants-icons">
                                    @isset($restaurants[3]->instagram_url)
                                        <a class="app-icon-btn" href="{{ $restaurants[3]->instagram_url }}" target="_blank">
                                            <img src="{{ asset('img/instagram.png') }}" alt="Instagram">
                                        </a>
                                    @endisset
                                    @isset($restaurants[3]->instagram_url)
                                        <a class="app-icon-btn" href="{{ $restaurants[3]->facebook_url }}" target="_blank">
                                            <img src="{{ asset('img/facebook.png') }}" alt="Facebook">
                                        </a>
                                    @endisset
                                    @isset($restaurants[3]->telegram_url)
                                        <a class="app-icon-btn" href="{{ $restaurants[3]->facebook_url }}" target="_blank">
                                            <img src="{{ asset('img/telegram.png') }}" alt="Telegram">
                                        </a>
                                    @endisset
                                </div>
                            </div>
                        </div>
                    @endisset
                </div>
                <div class="banner-content-btn-block">
                    <button class="banner-content-btn" style="text-transform: uppercase; font-weight: bold;">
                        <a href="{{ route('restaurant.country.list') }}">{{ __('More details') }}</a>
                    </button>
                </div>
            </div>
        </section>
    @endif

    @if ($manufacturers->isNotEmpty())
        <section class="company-logos-section" id="company-logos-section">
            <div class="container">
                <div class="restaurants-txt-content">
                    {!! render_block('manufacturers-header') !!}
                </div>

                <div class="company-logo-contents-wrapper">
                    @foreach ($manufacturers as $row)
                        <div class="company-logo-content">
                            <div class="company-logo-image">
                                <img  src="{{ $row->image->url }}" alt="{{ $row->name }}">
                            </div>
                            <p class="company-logo-txt">{{ $row->name }}</p>
                            <div class="company-logo-content-inner">
                                @isset($row->url)
                                    <a class="go-to-site-btn" href="{{ $row->url }}" target="_blank">
                                        {{ __('Visit website') }}
                                    </a>
                                @endisset
                                @isset($row->certificate)
                                        <a class="blue-button blue-button-secondary click-here"
                                           href="{{ $row->certificate->url }}" target="_blank">
                                            {{ __('View certificate') }}
                                        </a>
                                @endisset
                                <div class="restaurants-icons">
                                    @isset($row->instagram_url)
                                        <a class="app-icon-btn-secondary" href="{{ $row->instagram_url }}" target="_blank">
                                            <img src="{{ asset('img/instagram.svg') }}" alt="Instagram">
                                        </a>
                                    @endisset
                                    @isset($row->instagram_url)
                                        <a class="app-icon-btn-secondary" href="{{ $row->facebook_url }}" target="_blank">
                                            <img src="{{ asset('img/facebook.svg') }}" alt="Facebook">
                                        </a>
                                    @endisset
                                    @isset($row->telegram_url)
                                        <a class="app-icon-btn-secondary" href="{{ $row->facebook_url }}" target="_blank">
                                            <img src="{{ asset('img/telegram.svg') }}" alt="Telegram">
                                        </a>
                                    @endisset
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($chefs->isNotEmpty())
        <section class="strange-cards-section" id="strange-cards-section">
            <div class="container">
                <div class="restaurants-txt-content">
                    {!! render_block('chefs-header') !!}
                </div>
                <div class="strange-cards-main">
                    @foreach ($chefs as $row)
                        <div class="strange-card">
                            <img src="{{ $row->photo->url }}" alt="{{ $row->name }}">
                            <div class="strange-card-inner">
                                <span class="strange-card-inner-txt">{{ $row->name}}</span>
                                <div class="restaurants-icons">
                                    @isset($row->instagram_url)
                                        <a class="app-icon-btn-secondary" href="{{ $row->instagram_url }}" target="_blank">
                                            <img src="{{ asset('img/instagram.svg') }}" alt="Instagram">
                                        </a>
                                    @endisset
                                    @isset($row->instagram_url)
                                        <a class="app-icon-btn-secondary" href="{{ $row->facebook_url }}" target="_blank">
                                            <img src="{{ asset('img/facebook.svg') }}" alt="Facebook">
                                        </a>
                                    @endisset
                                    @isset($row->telegram_url)
                                        <a class="app-icon-btn-secondary" href="{{ $row->facebook_url }}" target="_blank">
                                            <img src="{{ asset('img/telegram.svg') }}" alt="Telegram">
                                        </a>
                                    @endisset
                                </div>
                                @isset($row->certificate)
                                    <a class="blue-button blue-button-secondary click-here"
                                       href="{{ $row->certificate->url }}" target="_blank">
                                        {{ __('View certificate') }}
                                    </a>
                                @endisset
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="banner-content-btn-block">
                    <a class="blue-button blue-button-secondary blue-button-third click-here" href="{{ route('chef.country.list') }}">
                        {{ __('More details') }}
                    </a>
                </div>
            </div>
        </section>
    @endif

    @if ($reps->isNotEmpty())
        <section class="country-flags-section" id="country-flags-section">
            <div>
                <div class="restaurants-txt-content">
                    {!! render_block('representatives-header') !!}
                </div>

                <div class="swiper country-flags-sd">
                    <div class="swiper-wrapper">
                        @foreach ($reps as $row)
                            <div class="swiper-slide country-card">
                                <div>
                                    @if ($row->pdf)
                                        <a href="{{ $row->pdf->url }}" target="_blank">
                                            <img src="{{ $row->flag->url }}" alt="{{ $row->name }}">
                                        </a>
                                    @else
                                        <img src="{{ $row->flag->url }}" alt="{{ $row->name }}">
                                    @endif
                                </div>
                                <p class="country-card-txt">{{ $row->name }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"><svg class="svg-icon-next" style="width: 1em; height: 1em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M688 224 656 192 336 512 336 512 320 528 656 864 688 832 384 528Z"  /></svg></div>
                    <div class="swiper-button-prev"><svg class="svg-icon" style="width: 1em; height: 1em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M688 224 656 192 336 512 336 512 320 528 656 864 688 832 384 528Z"  /></svg></div>
                </div>
            </div>
        </section>
    @endif

    @if ($partners->isNotEmpty())
        <section class="country-flags-section country-flags-section-secondary" id="section-partners">
            <div>
                <div class="restaurants-txt-content">
                    <span class="title-restaurants">
                        {{ __('Partners') }}
                    </span>
                </div>

                <div class="swiper country-flags-sd">
                    <div class="swiper-wrapper">
                        @foreach($partners as $row)
                            <div class="swiper-slide country-card">
                                <div>
                                    @if ($row->website_url)
                                        <a href="{{ $row->website_url }}" target="_blank">
                                            <img src="{{ $row->logo->url }}" alt="{{ $row->name }}">
                                        </a>
                                    @else
                                        <img src="{{ $row->logo->url }}" alt="{{ $row->name }}">
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"><svg class="svg-icon-next" style="width: 1em; height: 1em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M688 224 656 192 336 512 336 512 320 528 656 864 688 832 384 528Z"  /></svg></div>
                    <div class="swiper-button-prev"><svg class="svg-icon" style="width: 1em; height: 1em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M688 224 656 192 336 512 336 512 320 528 656 864 688 832 384 528Z"  /></svg></div>
                </div>
            </div>
        </section>
    @endif
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ vendor('swiper-11.1.0/swiper-bundle.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ vendor('swiper-11.1.0/swiper-bundle.min.js') }}"></script>
    <script>
        $(function () {
            new Swiper(".bannerSwiper", {});

            new Swiper(".country-flags-sd", {
                slidesPerView: 5,
                spaceBetween: 30,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    // when window width is >= 320px
                    320: {
                        slidesPerView: 1,
                        spaceBetween: 20
                    },
                    // when window width is >= 480px
                    480: {
                        slidesPerView: 4,
                        spaceBetween: 30
                    },
                    // when window width is >= 640px
                }
            });
        });
    </script>
@endpush
