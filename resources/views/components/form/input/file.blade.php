<div class="row">
    <div class="col-md-8">
        <div class="input-group mb-1">
            <input type="file" name="{{ $name }}" class="form-control" id="{{ $name }}"
                   accept="{{ $accept }}">
            <label class="input-group-text" for="{{ $name }}">
                {{ __('Upload') }}
            </label>
        </div>
    </div>
    <div class="col-md-4">
        @if (!is_null($current))
            <div class="current-view" style="margin-top: -3px;">
                <div class="current-view--container d-inline-block position-relative align-text-top">
                    <small>
                        <a href="{{ $current->url }}" target="_blank" class="text-decoration-none">
                            <i class="fa-duotone fa-fw fa-file"></i>{{ $current->name }}
                        </a>
                    </small>
                    <button class="btn btn-sm btn-danger" type="button" data-image-remove>
                        <i class="fa-duotone fa-fw fa-trash"></i>
                        {{ __('buttons.remove') }}
                    </button>
                    <input type="hidden" name="current_file" value="{{ $current->raw }}">
                </div>
            </div>
        @endif
    </div>
</div>
@isset($helpText)
    <x-form.text>
        {{ $helpText }}
    </x-form.text>
@endisset
