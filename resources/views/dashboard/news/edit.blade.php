@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-form.form :action="route('admin.news.save')">
                @isset($entry?->id)
                    <input type="hidden" name="id" value="{{ $entry->id }}">
                @endisset

                <x-card.card>
                    <x-slot:header>
                        <ul class="nav nav-pills mr-auto p-2">
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
                        </ul>
                    </x-slot:header>

                    <x-slot:body>
                        <div class="tab-content p-3">
                            <!-- General -->
                            <div class="tab-pane active" id="general">
                                <div class="form-group row">
                                    <div class="col">
                                        <div class="alert alert-warning">
                                            {{ __('When pasting copied content to the "Description" field, please make sure that the text you are pasting does not contain any HTML tags. Please use only allowed tags instead (which are shown at the editor toolbar).') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row required">
                                    <x-form.label for="title" class="col-md-3">
                                        {{ __('Title') }}
                                    </x-form.label>
                                    <div class="col-md-9">
                                        <input type="text" name="title" id="title" class="form-control"
                                               value="{{ old('title') ?? $entry?->title }}" maxlength="255" required>
                                    </div>
                                </div>

                                <div class="form-group row required">
                                    <x-form.label for="description" class="col-md-3">
                                        {{ __('Description') }}
                                    </x-form.label>
                                    <div class="col-md-9">
                                        <textarea name="description" id="description" cols="30" rows="5"
                                                  class="form-control summernote">
                                            {{ old('description') ?? $entry?->description }}
                                        </textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Media -->
                            <div class="tab-pane" id="media">
                                <div class="form-group row">
                                    <div class="col">
                                        <div class="alert alert-warning">
                                            {{ __('When adding media, keep in mind that the links must be direct, i.e. should lead to the file itself. Links to YouTube like https://youtube.com/abcdefgh will cause an error when publishing.') }}
                                            <br>
                                            {{ __('For example:') }}
                                            <ul>
                                                <li>
                                                    {{ __('For a photo the link should look like') }} <i>https://example.com/../filename.png</i> ({{ __('Type of a file my be any: png, jpg, etc.') }})
                                                </li>
                                                <li>
                                                    {{ __('For a video the link should look like') }} <i>https://example.com/../filename.mp4</i>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <x-form.label class="col-md-3">
                                        {{ __('Media') }}
                                    </x-form.label>
                                    <div class="col-md-9">
                                        <ul id="gallery" class="list-unstyled">
                                            @if (isset($entry) && $entry->media->isNotEmpty())
                                                @foreach ($entry->media as $index => $media)
                                                    <li class="d-flex" data-id="{{ $index + 1 }}">
                                                        <input type="hidden" name="media[{{ $index + 1 }}][id]"
                                                               value="{{ $media->id }}">
                                                        <div class="image-control d-flex" style="width: 100px;">
                                                            @if ($media->media_type === $typePhoto)
                                                                <img src="{{ $media->media_url }}" class="img-fluid" style="height: 33px;" data-fancybox>
                                                            @else
                                                                <video height="33">
                                                                    <source src="{{ $media->media_url }}#t=0.1" type="video/mp4">
                                                                </video>
                                                            @endif
                                                        </div>
                                                        <div class="d-flex me-1" style="width: 150px;">
                                                            <select name="media[{{ $index + 1 }}][type]" class="form-select" style="height: 33px;">
                                                                <option value="{{ $typePhoto }}"{{ $media->media_type === $typePhoto ? ' selected' : '' }}>
                                                                    {{ __('Photo') }}
                                                                </option>
                                                                <option value="{{ $typeVideo }}"{{ $media->media_type === $typeVideo ? ' selected' : '' }}>
                                                                    {{ __('Video') }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="input-group mb-1">
                                                            <input type="url" name="media[{{ $index + 1 }}][src]"
                                                                   id="media-{{ $index + 1 }}"
                                                                   class="form-control m-input"
                                                                   placeholder="https://..."
                                                                   autocomplete="off" value="{{ $media->media_url }}">
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
                                                            <option value="{{ $typePhoto }}">
                                                                {{ __('Photo') }}
                                                            </option>
                                                            <option value="{{ $typeVideo }}">
                                                                {{ __('Video') }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="input-group mb-1">
                                                        <input type="url" name="media[0][src]"
                                                               id="media-0"
                                                               class="form-control m-input"
                                                               placeholder="https://..."
                                                               autocomplete="off">
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
                                                        <option value="{{ $typePhoto }}">
                                                            {{ __('Photo') }}
                                                        </option>
                                                        <option value="{{ $typeVideo }}">
                                                            {{ __('Video') }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="input-group mb-1">
                                                    <input type="url" name=""
                                                           id="media-0"
                                                           class="form-control m-input"
                                                           placeholder="https://..."
                                                           autocomplete="off">
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
                        </div>
                    </x-slot:body>

                    <x-slot:footer>
                        <x-form.actions :back="route('admin.news.list')"/>
                    </x-slot:footer>
                </x-card.card>
            </x-form.form>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ vendor('summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ vendor('summernote-emoji-master/tam-emoji/css/emoji.css') }}">
@endpush

@push('scripts')
    <script type="module" src="{{ vendor('summernote/summernote-bs4.min.js') }}"></script>
    <script type="module" src="{{ vendor('summernote/lang/summernote-'.(str_replace('_', '-', LaravelLocalization::getCurrentLocaleRegional())).'.min.js') }}"></script>
    <script type="module" src="{{ vendor('summernote-emoji-master/tam-emoji/js/config.js') }}"></script>
    <script type="module" src="{{ vendor('summernote-emoji-master/tam-emoji/js/tam-emoji.min.js') }}"></script>
    <script>
        function CleanPastedHTML(input) {
            // 1. remove line breaks / Mso classes
            var stringStripper = /(\n|\r| class=(")?Mso[a-zA-Z]+(")?)/g;
            var output = input.replace(stringStripper, ' ');
            // 2. strip Word generated HTML comments
            var commentSripper = new RegExp('<!--(.*?)-->','g');
            var output = output.replace(commentSripper, '');
            var tagStripper = new RegExp('<(/)*(meta|link|span|\\?xml:|st1:|o:|font|ul|li|div|img|p)(.*?)>','gi');
            // 3. remove tags leave content if any
            output = output.replace(tagStripper, '');
            output = output.replace("&nbsp;", '');
            // 4. Remove everything in between and including tags '<style(.)style(.)>'
            var badTags = ['style', 'script','applet','embed','noframes','noscript'];

            for (var i=0; i< badTags.length; i++) {
                tagStripper = new RegExp('<'+badTags[i]+'.*?'+badTags[i]+'(.*?)>', 'gi');
                output = output.replace(tagStripper, '');
            }
            // 5. remove attributes ' style="..."'
            var badAttributes = ['style', 'start'];
            for (var i=0; i< badAttributes.length; i++) {
                var attributeStripper = new RegExp(' ' + badAttributes[i] + '="(.*?)"','gi');
                output = output.replace(attributeStripper, '');
            }
            return output;
        }

        $(function () {
            document.emojiType = 'unicode';
            document.emojiSource = '{{ vendor('summernote-emoji-master/tam-emoji/img') }}';

            $('.summernote').summernote({
                lang: '{{ str_replace('_', '-', LaravelLocalization::getCurrentLocaleRegional()) }}',
                height: 250,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['insert', ['link', 'emoji']]
                ],
                callbacks: {
                    onPaste: function (e) {
                        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');

                        e.preventDefault();

                        // Firefox fix
                        setTimeout(function () {
                            document.execCommand('insertText', false, CleanPastedHTML(bufferText));
                        }, 10);
                    }
                }
            });

            const container = document.querySelector('#gallery');
            const blockTemplate = document.getElementById('template-block');

            var dataIdCount = document.querySelectorAll('#gallery>li.d-flex').length;

            function createBlockElement()
            {
                const blockId = dataIdCount + 1;
                const newBlock = blockTemplate.cloneNode(true);
                const imageInput = newBlock.querySelector('#media-0');
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
                if (dataIdCount < 10) {
                    const newBlock = createBlockElement();
                    container.appendChild(newBlock);
                }
            });
        });
    </script>
@endpush
