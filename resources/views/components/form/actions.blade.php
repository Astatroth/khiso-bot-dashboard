<div class="form-actions">
    <button class="btn btn-success" type="submit">
        <i class="{{ $icon }} fa-fw"></i>
        @if (!is_null($buttonText))
            {{ $buttonText }}
        @else
            {{ __('buttons.save') }}
        @endif
    </button>

    @if(!is_null($back))
        <a href="{{ $back }}" class="btn btn-outline-secondary">
            <i class="fa-duotone fa-times fa-fw"></i>
            {{ __('buttons.cancel') }}
        </a>
    @endif

    {{ $slot }}
</div>
