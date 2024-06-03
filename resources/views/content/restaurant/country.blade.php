@extends('layouts.app')

@section('content')
    <section class="chefs-section">
        <div class="container">

            <div class="restaurants-txt-content">
                <span class="title-restaurants">
                    {{ __('Halal restaurant from over the World') }}
                </span>
                <p class="restaurants-txt">
                    {{ __('Here you can find halal restaurants from all over the world') }}
                </p>
            </div>

            <div class="chefs-tab">
                @foreach ($countries->keys() as $region)
                    <button class="tablinks" onclick="openCity(event, '{{ $region }}')">
                        {{ $region }}
                    </button>
                @endforeach
            </div>

            @foreach ($countries as $region => $collection)
                <div id="{{ $region }}" class="tabcontent">
                    <div class="chef-card-wrapper">
                        @foreach ($collection as $country)
                            <div class="chef-card-content">
                                <a class="chef-card-link" href="{{ route('restaurant.list', $country->name) }}"></a>
                                {{ $country->name }}
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(function () {
            function openCity(evt, cityName) {
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                document.getElementById(cityName).style.display = "block";
                evt.currentTarget.className += " active";
            }
        });
    </script>
@endpush
