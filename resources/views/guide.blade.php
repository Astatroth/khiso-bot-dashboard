@extends('layouts.app')

@section('content')
    <section class="map-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <select class="form-select" id="category">
                        <option value="none">{{ __('Choose category') }}</option>
                        <option value="restaurants">{{ __('Restaurants') }}</option>
                        <option value="manufacturers">{{ __('Manufacturers') }}</option>
                        <option value="hotels">{{ __('Hotels') }}</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <select class="form-select" id="country">
                        <option value="none">{{ __('Choose country') }}</option>
                        @foreach($regions as $region => $countries)
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://api-maps.yandex.ru/2.1/?apikey=ce8f27db-6bab-46ee-a35f-e05b1e0ce00a&lang=ru_RU"
            type="text/javascript"></script>
    <script>
        $(function () {
            var map;
            var $category = $('#category');
            var $country = $('#country');
            var styles = {
                'hotels': 'islands#blueStretchyIcon',
                'manufacturers': 'islands#greenStretchyIcon',
                'restaurants': 'islands#violetStretchyIcon',
            };

            ymaps.ready(init);

            function init()
            {
                map = new ymaps.Map("map", {
                    center: ['41.313741', '69.253398'],
                    zoom: 12,
                    controls: ['zoomControl']
                });
            }

            function loadPlacemarks(countryId, category)
            {
                if (map) {
                    $.ajax({
                        url: '{{ route('guide.update') }}',
                        method: 'get',
                        data: {
                            category: category,
                            countryId: countryId
                        },
                        dataType: 'json',
                        beforeSend: () => {
                            map.geoObjects.removeAll();
                        },
                        success: response => {
                            if (response.data.length) {
                                response.data.forEach((i, k) => {
                                    let coordinates = [i.latitude, i.longitude];

                                    let placemark = new ymaps.Placemark(
                                        coordinates,
                                        {
                                            iconContent: '<div>' + (i.name ?? i.title) + '</div>'
                                        },
                                        {preset: styles[category]}
                                    );

                                    map.geoObjects.add(placemark);
                                });
                            }
                        }
                    });
                }
            }

            $category.on('change', () => {
                if ($country.val() !== 'none' && $category.val() !== 'none') {
                    loadPlacemarks($country.val(), $category.val());
                }
            });

            $country.on('change', () => {
                if ($category.val() !== 'none' && $country.val() !== 'none') {
                    loadPlacemarks($country.val(), $category.val());
                }
            });
        });
    </script>
@endpush
