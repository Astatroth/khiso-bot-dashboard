@isset($block)
    <div class="block-render" id="block-{{ $block->slug }}">
        {!! $block->body !!}
    </div>
@endisset
