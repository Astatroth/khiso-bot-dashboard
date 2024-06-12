@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-form.form :action="route('admin.olympiad.save')" :files="true">
                @isset($entry?->id)
                    <input type="hidden" name="id" value="{{ $entry->id }}">
                @endisset

                <x-card.card>
                    <x-slot:body>
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
                                          class="form-control summernote">{{ old('description') ?? $entry?->description }}
                                </textarea>
                                <span id="total-characters"></span>
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

                        <div class="form-group row required">
                            <label for="start-date" class="control-label col-form-label text-end col-md-3">
                                {{ __('Start date') }}
                            </label>
                            <div class="col-md-2">
                                <div class="input-group date">
                                    <input type="text" id="start-date" class="form-control" name="starts_at"
                                           value="{{ old('starts_at', $entry?->starts_at->date) }}">
                                    <span class="input-group-text">
                                        <i class="fa-duotone fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row required">
                            <label for="end-date" class="control-label col-form-label text-end col-md-3">
                                {{ __('End date') }}
                            </label>
                            <div class="col-md-2">
                                <div class="input-group date">
                                    <input type="text" id="end-date" class="form-control" name="ends_at"
                                           value="{{ old('ends_at', $entry?->ends_at->date) }}">
                                    <span class="input-group-text">
                                        <i class="fa-duotone fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row required">
                            <x-form.label for="time_limit" class="col-md-3">
                                {{ __('Time limit') }}
                            </x-form.label>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <input type="number" id="time_limit" class="form-control" name="time_limit"
                                           value="{{ old('time_limit', $entry?->time_limit) }}" min="10">
                                    <span class="input-group-text">
                                        {{ __('minutes') }}
                                    </span>
                                </div>
                                <x-form.text>
                                    {{ __('Minimum - 10 minutes') }}
                                </x-form.text>
                            </div>
                        </div>
                    </x-slot:body>

                    <x-slot:footer>
                        <x-form.actions :back="route('admin.olympiad.list')"/>
                    </x-slot:footer>
                </x-card.card>
            </x-form.form>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ vendor('summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ vendor('summernote-emoji-master/tam-emoji/css/emoji.css') }}">
    <link rel="stylesheet" href="{{ vendor('tempus-dominus-6.9.9/css/tempus-dominus.min.css') }}">
@endpush

@push('scripts')
    <script type="module" src="{{ vendor('summernote/summernote-bs4.min.js') }}"></script>
    <script type="module" src="{{ vendor('summernote/lang/summernote-'.(str_replace('_', '-', LaravelLocalization::getCurrentLocaleRegional())).'.min.js') }}"></script>
    <script type="module" src="{{ vendor('summernote-emoji-master/tam-emoji/js/config.js') }}"></script>
    <script type="module" src="{{ vendor('summernote-emoji-master/tam-emoji/js/tam-emoji.min.js') }}"></script>
    <script type="module" src="{{ vendor('popperjs-2.11.8/popper.min.js') }}"></script>
    <script type="module" src="{{ vendor('tempus-dominus-6.9.9/js/tempus-dominus.min.js') }}"></script>
    <script type="module" src="{{ vendor('tempus-dominus-6.9.9/locales/ru.js') }}"></script>
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

        const charactersLimit = 745;

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
                    onKeydown: function (e) {
                        let characters = $('.summernote').summernote('code').replace(/(<([^>]+)>)/ig, "");
                        let totalCharacters = characters.length;
                        $("#total-characters").text(totalCharacters + " / " + charactersLimit);
                        var t = e.currentTarget.innerText;
                        if (t.trim().length >= charactersLimit) {
                            if (e.keyCode != 8 && !(e.keyCode >= 37 && e.keyCode <= 40) && e.keyCode != 46 && !(e.keyCode == 88 && e.ctrlKey) && !(e.keyCode == 67 && e.ctrlKey)) e.preventDefault();
                        }
                    },
                    onKeyup: function(e) {
                        var t = e.currentTarget.innerText;
                        $('.summernote').text(charactersLimit - t.trim().length);
                    },
                    onPaste: function (e) {
                        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');

                        e.preventDefault();

                        // Firefox fix
                        setTimeout(function () {
                            document.execCommand('insertText', false, CleanPastedHTML(bufferText));
                        }, 10);

                        let characters = $('.summernote').summernote('code').replace(/(<([^>]+)>)/ig, "");
                        let totalCharacters = characters.length;
                        $("#total-characters").text(totalCharacters + " / " + charactersLimit);
                        var t = e.currentTarget.innerText;
                        var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
                        e.preventDefault();
                        var maxPaste = bufferText.length;
                        if (t.length + bufferText.length > charactersLimit) {
                            maxPaste = charactersLimit - t.length;
                        }
                        if (maxPaste > 0) {
                            document.execCommand('insertText', false, bufferText.substring(0, maxPaste));
                        }
                        $('.summernote').text(charactersLimit - t.length);
                    }
                }
            });

            const options = {
                localization: {
                    locale: 'ru',
                    format: 'dd.MM.yyyy H:mm'
                },
                restrictions: {
                    minDate: new Date()
                }
            }
            new tempusDominus.TempusDominus(document.getElementById('start-date'), options);
            new tempusDominus.TempusDominus(document.getElementById('end-date'), options);
        });
    </script>
@endpush
