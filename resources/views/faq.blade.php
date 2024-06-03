@extends('layouts.app')

@section('content')
    <section class="accardion-section-main">
        <div class="restaurants-txt-content">
            <span class="title-restaurants">
                {{ __('FAQ') }}
            </span>
        </div>
        <div class="container" style="margin-top: 50px;">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                @foreach ($questions as $index => $item)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-{{ $index }}" aria-expanded="false" aria-controls="flush-{{ $index }}">
                                {!! $item->question !!}
                            </button>
                        </h2>
                        <div id="flush-{{ $index }}" class="accordion-collapse collapse" aria-labelledby="flush-{{ $index }}" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                {!! $item->answer !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
