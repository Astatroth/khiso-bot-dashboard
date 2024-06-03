@php use App\Models\News\NewsMedia; @endphp
@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-form.form :action="route('admin.content.news.save')" :files="true">
                @isset($entry?->id)
                    <input type="hidden" name="id" value="{{ $entry->id }}">
                @endisset

                @isset($entry?->entry_id)
                    <input type="hidden" name="entry_id" value="{{ $entry->entry_id }}">
                @endisset

                <x-card.card>
                    <x-slot:header>
                        <ul class="nav nav-pills mr-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="#general" data-bs-toggle="tab">
                                    {{ __('General') }} *
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#media" data-bs-toggle="tab">
                                    {{ __('Media') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#seo" data-bs-toggle="tab">
                                    {{ __('SEO') }}
                                </a>
                            </li>
                        </ul>
                    </x-slot:header>

                    <x-slot:body>
                        <div class="tab-content p-3">
                            <!-- General -->
                            <div class="tab-pane active" id="general">
                                <div class="form-group row">
                                    <x-form.label for="language" class="col-md-3">
                                        {{ __('Language') }}
                                    </x-form.label>
                                    <div class="col-md-3">
                                        <select name="language" id="language" class="form-select">
                                            @foreach (LaravelLocalization::getLocalesOrder() as $key => $locale)
                                                <option value="{{ $key }}"{{ old('language') === $key || ($entry && $entry->language === $key) ? ' selected' : null }} data-flag="{{ $locale['flag'] ?? $key }}">
                                                    {{ $locale['native'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row required">
                                    <x-form.label for="title" class="col-md-3">
                                        {{ __('Title') }}
                                    </x-form.label>
                                    <div class="col-md-9">
                                        <input type="text" name="title" id="title" class="form-control"
                                               value="{{ old('title') ?? $entry?->title }}" maxlength="255">
                                    </div>
                                </div>

                                <div class="form-group row required">
                                    <x-form.label for="content" class="col-md-3">
                                        {{ __('Content') }}
                                    </x-form.label>
                                    <div class="col-md-9">
                                            <textarea class="form-control" name="body"
                                                      id="content">{{ old('body') ?? $entry?->body }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row{{ is_null($entry) ? ' required' : '' }}">
                                    <x-form.label for="image" class="col-md-3">
                                        {{ __('Image') }}
                                    </x-form.label>
                                    <div class="col-md-9">
                                        <x-form.input.image name="image" :current="$entry?->image">
                                            <x-slot:help-text>
                                                {{ __('Allowed file types: jpg, jpeg, png, webp.') }}<br>
                                                {{ __('Maximum size: 5 MB.') }}
                                            </x-slot:help-text>
                                        </x-form.input.image>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="publish-date" class="control-label col-form-label text-end col-md-3">
                                        {{ __('Publish date') }}
                                    </label>
                                    <div class="col-md-2">
                                        <div class="input-group date">
                                            <input type="text" id="publish-date" class="form-control" name="published_at" value="{{ old('published_at', $entry?->published_at->date) }}">
                                            <span class="input-group-text">
                                                <i class="fa-duotone fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Media -->
                            <div class="tab-pane" id="media">
                                <div class="form-group row">
                                    <x-form.label class="col-md-3">
                                        {{ __('Media') }}
                                    </x-form.label>
                                    <div class="col-md-9">
                                        <ul id="gallery" class="list-unstyled">
                                            @if (isset($entry) && $entry->media->isNotEmpty())
                                                @foreach ($entry->media as $index => $media)
                                                    <li class="d-flex" data-id="{{ $index + 1 }}">
                                                        <div class="image-control d-flex" style="width: 100px;">
                                                            @if ($media->type === NewsMedia::TYPE_PHOTO)
                                                                <img src="{{ $media->source->url }}" class="img-fluid" style="height: 33px;" data-fancybox>
                                                            @else
                                                                <video height="33">
                                                                    <source src="{{ $media->source->url }}#t=0.1" type="video/mp4">
                                                                </video>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex me-1" style="width: 150px;">
                                                            <select name="media[{{ $index + 1 }}][type]" class="form-select" style="height: 33px;">
                                                                <option value="{{ NewsMedia::TYPE_PHOTO }}"{{ $media->type === NewsMedia::TYPE_PHOTO ? ' selected' : '' }}>
                                                                    {{ __('Photo') }}
                                                                </option>
                                                                <option value="{{ NewsMedia::TYPE_VIDEO }}"{{ $media->type === NewsMedia::TYPE_VIDEO ? ' selected' : '' }}>
                                                                    {{ __('Video') }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="input-group mb-1">
                                                            <input type="file" name="media[{{ $index + 1 }}][src]" class="form-control" id="image-{{ $index + 1 }}"
                                                                   accept="image/jpg,image/jpeg,image/png,image/webp,video/mp4">
                                                            <label class="input-group-text">
                                                                {{ __('Upload') }}
                                                            </label>
                                                        </div>
                                                        @if ($loop->first)
                                                            <div class="button-control d-flex" style="width: 300px; height: 33px;">
                                                                <button class="btn btn-sm btn-primary ms-1" type="button" id="add-button">
                                                                    <i class="fa-duotone fa-plus"></i>
                                                                    {{ __('buttons.add') }}
                                                                </button>
                                                            </div>
                                                        @else
                                                            <div class="button-control d-flex" style="width: 300px; height: 33px;">
                                                                <button class="btn btn-sm btn-danger ms-1" type="button">
                                                                    <i class="fa-duotone fa-trash"></i>
                                                                    {{ __('buttons.remove') }}
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            @else
                                                <li class="d-flex" data-id="0">
                                                    <div class="image-control d-flex" style="width: 100px;">

                                                    </div>
                                                    <div class="d-flex me-1" style="width: 150px;">
                                                        <select name="media[0][type]" class="form-select" style="height: 33px;">
                                                            <option value="{{ NewsMedia::TYPE_PHOTO }}">
                                                                {{ __('Photo') }}
                                                            </option>
                                                            <option value="{{ NewsMedia::TYPE_VIDEO }}">
                                                                {{ __('Video') }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="input-group mb-1">
                                                        <input type="file" name="media[0][src]" class="form-control" id="image-0"
                                                               accept="image/jpg,image/jpeg,image/png,image/webp,video/mp4">
                                                        <label class="input-group-text">
                                                            {{ __('Upload') }}
                                                        </label>
                                                    </div>
                                                    <div class="button-control d-flex" style="width: 300px; height: 33px;">
                                                        <button class="btn btn-sm btn-primary ms-1" type="button" id="add-button">
                                                            <i class="fa-duotone fa-plus"></i>
                                                            {{ __('buttons.add') }}
                                                        </button>
                                                    </div>
                                                </li>
                                            @endif

                                            <!-- Template block -->
                                            <li id="template-block" class="d-none" data-id="0">
                                                <div class="image-control d-flex" style="width: 100px;">

                                                </div>
                                                <div class="d-flex me-1" style="width: 150px;">
                                                    <select name="media[0][type]" class="form-select" style="height: 33px;">
                                                        <option value="{{ NewsMedia::TYPE_PHOTO }}">
                                                            {{ __('Photo') }}
                                                        </option>
                                                        <option value="{{ NewsMedia::TYPE_VIDEO }}">
                                                            {{ __('Video') }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="input-group mb-1">
                                                    <input type="file" name="" class="form-control" id="image-0"
                                                           accept="image/jpg,image/jpeg,image/png,image/webp,video/mp4">
                                                    <label class="input-group-text">
                                                        {{ __('Upload') }}
                                                    </label>
                                                </div>
                                                <div class="button-control d-flex" style="width: 300px; height: 33px;">
                                                    <button class="btn btn-sm btn-danger ms-1" type="button">
                                                        <i class="fa-duotone fa-trash"></i>
                                                        {{ __('buttons.remove') }}
                                                    </button>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- SEO -->
                            <div class="tab-pane" id="seo">
                                @include('dashboard.seo.form', ['entry' => $entry, 'defaultType' => 'article'])
                            </div>
                        </div>
                    </x-slot:body>

                    <x-slot:footer>
                        <x-form.actions :back="route('admin.content.news.list')"/>
                    </x-slot:footer>
                </x-card.card>
            </x-form.form>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ vendor('select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ vendor('bootstrap-datepicker/css/bootstrap-datepicker.standalone.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ vendor('ckeditor/ckeditor.js') }}"></script>
    <script src="{{ vendor('select2/js/select2.full.min.js') }}"></script>
    <script src="{{ vendor('select2/js/i18n/'.(app()->getLocale()).'.js') }}"></script>
    <script src="{{ vendor('bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ vendor('bootstrap-datepicker/locales/bootstrap-datepicker.'.(app()->getLocale()).'.min.js') }}"></script>
    <script>
        $(function () {
            function formatLanguage(language) {
                if (!language.id) {
                    return language.text;
                }

                let $language = $('<span><span class="flag-icon flag-icon-'
                    + language.element.getAttribute('data-flag') + '"></span>&nbsp;' + language.text + '</span>');

                return $language;
            }

            $(function () {
                $('#language').select2({
                    language: '{{ app()->getLocale() }}',
                    minimumResultsForSearch: -1,
                    templateResult: formatLanguage,
                    templateSelection: formatLanguage
                });

                $('#country').select2({
                    language: '{{ app()->getLocale() }}'
                });
            });

            CKEDITOR.replace('content', {
                filebrowserImageBrowseUrl: '/dashboard/laravel-filemanager?type=Files',
                filebrowserImageUploadUrl: '/dashboard/laravel-filemanager/upload?type=Files&_token=',
                filebrowserBrowseUrl: '/dashboard/laravel-filemanager?type=Files',
                filebrowserUploadUrl: '/dashboard/laravel-filemanager/upload?type=Files&_token=',
                height: 500,
                language: "{{ $ckeditorLocale }}",
                allowedContent: true
            });

            $('#publish-date').datepicker({
                format: 'dd.mm.yyyy',
                language: '{{ app()->getLocale() }}',
                endDate: '0d',
                defaultViewDate: '{{ now()->format('d.m.Y') }}'
            });

            const container = document.querySelector('#gallery');
            const blockTemplate = document.getElementById('template-block');

            var dataIdCount = document.querySelectorAll('#gallery>li.d-flex').length;

            function createBlockElement()
            {
                const blockId = dataIdCount++;
                const newBlock = blockTemplate.cloneNode(true);
                const imageInput = newBlock.querySelector('#image-0');
                const select = newBlock.querySelector('select');
                const button = newBlock.querySelector('.btn-danger');

                newBlock.setAttribute('data-id', blockId);
                imageInput.name = 'media[' + blockId + '][src]';
                imageInput.id = 'image-' + blockId;
                select.name = 'media[' + blockId + '][type]';

                button.addEventListener('click', removeBlock);

                newBlock.classList.remove('d-none');
                newBlock.classList.add('d-flex');
                newBlock.removeAttribute('id');

                return newBlock;
            }

            function removeBlock(event)
            {
                const block = event.target.closest('li');
                block.parentNode.removeChild(block);
            }

            const addButton = document.getElementById('add-button');
            addButton.addEventListener('click', () => {
                const newBlock = createBlockElement();
                container.appendChild(newBlock);
            });
        });
    </script>
@endpush
