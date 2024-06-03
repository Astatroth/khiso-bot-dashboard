@if (isset($entry) && isset($entry->seo))
    <input type="hidden" name="seo_entry_id" value="{{ $entry->seo->id }}">
@endif

<div class="form-group row">
    <label for="og-title" class="control-label col-form-label text-end col-md-3">
        {{ __('OpenGraph title') }}
    </label>
    <div class="col-md-9">
        <input type="text" id="og-title" class="form-control" name="og_title"
               maxlength="80"
               aria-describedby="og-title-help-text"
               value="{{ old('og_title') ?? ($entry && isset($entry->seo) ? $entry->seo->og_title : null) }}">
        <small class="form-text text-muted" id="og-title-help-text">
            {{ __('OpenGraph title can differ from a page title.') }}<br>
            {{ __('Maximum length is 80 characters, however it is recommended that you keep it under 60 characters.') }}
        </small>
    </div>
</div>

<div class="form-group row">
    <label for="seo-description" class="control-label col-form-label text-end col-md-3">
        {{ __('Description') }}
    </label>
    <div class="col-md-9">
        <input type="text" id="seo-description" class="form-control" name="seo_description"
               value="{{ old('seo_description') ?? ($entry && isset($entry->seo) ? $entry->seo->description : null) }}"
               aria-describedby="description-help-text" maxlength="255">
        <small class="form-text text-muted" id="description-help-text">
            {{ __('Recommended maximum length - 155 characters.') }}
        </small>
    </div>
</div>

<div class="form-group row">
    <label for="og-type" class="control-label col-form-label text-end col-md-3">
        {{ __('OpenGraph type') }}
    </label>
    <div class="col-md-2">
        <select name="og_type" id="og-type" class="form-control" style="width: 100%">
            <optgroup label="{{ __('Music') }}">
                <option value="music.song">{{ __('Song') }}</option>
                <option value="music.album">{{ __('Album') }}</option>
                <option value="music.playlist">{{ __('Playlist') }}</option>
                <option value="music.radio_station">{{ __('Radio station') }}</option>
            </optgroup>
            <optgroup label="{{ __('Video') }}">
                <option value="video.movie">{{ __('Movie') }}</option>
                <option value="video.episode">{{ __('Episode') }}</option>
                <option value="video.tv_show">{{ __('TV show') }}</option>
                <option value="video.other">{{ __('Other') }}</option>
            </optgroup>
            <option value="article">{{ __('Article') }}</option>
            <option value="book">{{ __('Book') }}</option>
            <option value="profile">{{ __('Profile') }}</option>
            <option value="website">{{ __('Website') }}</option>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="og-image" class="control-label col-form-label text-end col-md-3">
        {{ __('OpenGraph image') }}
    </label>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-8">
                <div class="input-group mb-1">
                    <input type="file" name="og_image" class="form-control" id="og_image"
                           accept="image/jpg,image/jpeg,image/png,image/webp">
                </div>
            </div>
            <div class="col-md-4">
                @if ($entry && isset($entry->seo->og_image))
                    <div class="current-view" style="margin-top: -3px;">
                        <div class="current-view--container d-inline-block position-relative align-text-top">
                            <img src="{{ $entry->seo->og_image->url }}" class="img-fluid" style="height: 33px;" data-fancybox>
                            <button class="btn btn-sm btn-danger" type="button" data-image-remove>
                                <i class="fa fa-fw fa-trash"></i>
                                {{ __('buttons.remove') }}
                            </button>
                            <input type="hidden" name="current_og_image" value="{{ $entry->seo->og_image->raw }}">
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <small class="form-text text-muted">
            {{ __('Allowed file types: jpg, jpeg, png, webp.') }}<br>
            {{ __('For og:image , use high-quality images with dimensions of at least 1,200x630 pixels, while keeping the file size under 8 MB.')  }}
        </small>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ vendor('select2/css/select2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ vendor('select2/js/select2.full.min.js') }}"></script>
    <script src="{{ vendor('select2/js/i18n/'.(app()->getLocale()).'.js') }}"></script>
    <script>
        $(function () {
            $('#og-type').select2({
                language: '{{ app()->getLocale() }}',
                minimumResultsForSearch: -1
            });

            @if (old('og_type') || isset($entry))
            $('#og-type').val('{{ old('og_type') ?? (isset($entry) && isset($entry->seo) ? $entry->seo->og_type : 'website') }}').trigger('change');
            @else
            $('#og-type').val('{{ $defaultType ?? 'website' }}').trigger('change');
            @endif
        });
    </script>
@endpush
