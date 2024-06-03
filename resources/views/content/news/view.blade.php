@extends('layouts.app')

@section('content')
    <section class="news-section">
        <div class="container">
            <div class="">
                <p class="title-restaurants additional">
                    {{ __('News') }}
                </p>
                <p class="secondary-txt-title">
                    Halal News
                </p>
            </div>
            <div class="see-more-contents-wrapper">
                @if ($collection->isNotEmpty())
                    @foreach ($collection as $item)
                        <div class="see-more-card">
                            <a class="card-link" href="{{ route('news.page', $item->slug) }}"></a>
                            <div class="see-more-card-img">
                                <img src="{{ $item->image->url }}" alt="{{ $item->title }}">
                            </div>
                            <div class="see-more-inner">
                                <span class="see-more-title">
                                    {{ $item->title }}
                                </span>
                                <p class="see-more-txt">
                                    {{ \Str::limit(strip_tags($item->bodyStripped), 100, '...') }}
                                </p>
                                <p class="date-bold">
                                    {{ beautify_month_name($item->published_at->raw) }}
                                </p>
                                <button class="another-blue  click-here" style="font-weight: 400;">
                                    <a href="{{ route('news.page', $item->slug) }}">
                                        {{ __('See more') }}
                                    </a>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif

                <div id="pagination-wrapper">
                    {!! $collection->links('vendor.pagination.halal') !!}
                </div>
            </div>
        </div>
    </section>
@endsection
