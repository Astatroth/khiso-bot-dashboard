@php use App\Models\News\NewsMedia; @endphp
@extends('layouts.app')

@section('content')
    <section class="conference-section">
        <div class="container">
            <div class="conference-main">
                <div>
                    <p class="title-restaurants additional title-conference">
                        {{ $entry->title }}
                    </p>
                </div>

                @if ($entry->media->isNotEmpty())
                    <div class="conference-images">
                        @foreach ($entry->media->filter(fn ($i) => $i->type === NewsMedia::TYPE_PHOTO) as $photo)
                            <div class="conference-image-content">
                                <img src="{{ $photo->source->url }}" alt="{{ $entry->title }}">
                            </div>
                        @endforeach
                    </div>
                    <div class="conference-images">
                        @foreach ($entry->media->filter(fn ($i) => $i->type === NewsMedia::TYPE_VIDEO) as $video)
                            <video width="250" height="450" controls>
                                <source src="{{ $video->source->url }}">
                            </video>
                        @endforeach
                    </div>
                @endif

                <div class="page-content">
                    {!! $entry->body !!}
                </div>
            </div>
        </div>
    </section>
@endsection
