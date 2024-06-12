@php use App\Models\Question; @endphp
@extends('dashboard.layout')

@section('content')
    <div class="row">
        <div class="col">
            <x-form.form :action="route('admin.olympiad.question.save')" :files="true">
                @isset($entry?->id)
                    <input type="hidden" name="id" value="{{ $entry->id }}">
                @endisset

                <input type="hidden" name="olympiad_id" value="{{ $olympiadId }}">

                <x-card.card>
                    <x-slot:header>
                        <ul class="nav nav-pills mr-auto p-0">
                            <li class="nav-item">
                                <a class="nav-link active" href="#question" data-bs-toggle="tab">
                                    {{ __('Question') }} *
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#answers" data-bs-toggle="tab">
                                    {{ __('Answers') }} *
                                </a>
                            </li>
                        </ul>
                    </x-slot:header>

                    <x-slot:body>
                        <div class="tab-content p-3">
                            <!-- Question -->
                            <div class="tab-pane active" id="question">
                                <div class="form-group row required">
                                    <x-form.label for="title" class="col-md-3">
                                        {{ __('Title') }}
                                    </x-form.label>
                                    <div class="col-md-9">
                                        <input type="text" name="title" id="title" class="form-control"
                                               value="{{ old('title') ?? $entry?->title }}" maxlength="255" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <x-form.label for="type" class="col-md-3">
                                        {{ __('Question type') }}
                                    </x-form.label>
                                    <div class="col-md-3">
                                        <select name="question_type" id="type" class="form-select">
                                            @foreach ($types as $value => $label)
                                                <option value="{{ $value }}" {{ old('question_type') === $value || $entry?->type === $value ? 'selected' : null }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <fieldset id="type-{{ Question::TYPE_TEXT }}">
                                    <div class="form-group row">
                                        <div class="col">
                                            <div class="alert alert-warning">
                                                {{ __('When pasting copied content to the "Description" field, please make sure that the text you are pasting does not contain any HTML tags. Please use only allowed tags instead (which are shown at the editor toolbar).') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row required">
                                        <x-form.label for="question_content_text" class="col-md-3">
                                            {{ __('Content') }}
                                        </x-form.label>
                                        <div class="col-md-9">
                                            <textarea name="question_content_text" id="question_content_text" cols="30" rows="5"
                                                      class="form-control summernote">{{ old('question_content_text') ?? (isset($entry) && $entry->type === Question::TYPE_TEXT ? $entry->content : null) }}
                                            </textarea>
                                            <span id="total-characters"></span>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset id="type-{{ Question::TYPE_IMAGE }}" class="d-none">
                                    <div class="form-group row{{ is_null($entry) ? ' required' : '' }}">
                                        <x-form.label for="question_content_image" class="col-md-3">
                                            {{ __('Content') }}
                                        </x-form.label>
                                        <div class="col-md-9">
                                            @if (isset($entry) && $entry->type === Question::TYPE_IMAGE)
                                                <x-form.input.image name="question_content_image" :current="$entry?->content">
                                                    <x-slot:help-text>
                                                        {{ __('Allowed file types: jpg, jpeg, png, webp.') }}<br>
                                                        {{ __('Maximum size: 5 MB.') }}
                                                    </x-slot:help-text>
                                                </x-form.input.image>
                                            @else
                                                <x-form.input.image name="question_content_image">
                                                    <x-slot:help-text>
                                                        {{ __('Allowed file types: jpg, jpeg, png, webp.') }}<br>
                                                        {{ __('Maximum size: 5 MB.') }}
                                                    </x-slot:help-text>
                                                </x-form.input.image>
                                            @endif
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset id="type-{{ Question::TYPE_DOCUMENT }}" class="d-none">
                                    <div class="form-group row{{ is_null($entry) ? ' required' : '' }}">
                                        <x-form.label for="question_content_document" class="col-md-3">
                                            {{ __('Content') }}
                                        </x-form.label>
                                        <div class="col-md-9">
                                            @if (isset($entry) && $entry->type === Question::TYPE_DOCUMENT)
                                                <x-form.input.file accept="pdf" name="question_content_document"
                                                               :current="$entry?->content">
                                                    <x-slot:help-text>
                                                        {{ __('Allowed file types: pdf.') }}<br>
                                                        {{ __('Maximum size: 5 MB.') }}
                                                    </x-slot:help-text>
                                                </x-form.input.file>
                                            @else
                                                <x-form.input.file accept="pdf" name="question_content_document">
                                                    <x-slot:help-text>
                                                        {{ __('Allowed file types: pdf.') }}<br>
                                                        {{ __('Maximum size: 5 MB.') }}
                                                    </x-slot:help-text>
                                                </x-form.input.file>
                                            @endif
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="form-group row required">
                                    <x-form.label for="correct_answer_cost" class="col-md-3">
                                        {{ __('Correct answer cost') }}
                                    </x-form.label>
                                    <div class="col-md-1">
                                        <div class="input-group">
                                            <input type="number" name="correct_answer_cost" id="correct_answer_cost"
                                                   class="form-control" min="1"
                                                   value="{{ old('correct_answer_cost', $entry?->correct_answer_cost) }}">
                                            <span class="input-group-text">
                                                > 0
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row required">
                                    <x-form.label for="wrong_answer_cost" class="col-md-3">
                                        {{ __('Wrong answer cost') }}
                                    </x-form.label>
                                    <div class="col-md-1">
                                        <div class="input-group">
                                            <input type="number" name="wrong_answer_cost" id="wrong_answer_cost"
                                                   class="form-control" max="-1"
                                                   value="{{ old('wrong_answer_cost', $entry?->wrong_answer_cost) }}">
                                            <span class="input-group-text">
                                                < 0
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Answers -->
                            <div class="tab-pane" id="answers">
                                @foreach (['a', 'b', 'c', 'd'] as $index => $variant)
                                    <div class="form-group row">
                                        <x-form.label for="variant-{{ $variant }}" class="col-md-3">
                                            {{ __('Variant :x', ['x' => strtoupper($variant)]) }}
                                        </x-form.label>
                                        <div class="col-md-9">
                                            <input type="text" @class(['form-control', 'variants', 'border-success' => isset($entry) && $entry->answers[$index]->is_correct])
                                                   name="variants[{{ $entry?->answers[$index]->id ?? $index + 1 }}]"
                                                   id="variant-{{ $variant }}"
                                                   value="{{ old('variants')[$index + 1] ?? $entry?->answers[$index]->answer }}"
                                                   maxlength="255">
                                        </div>
                                    </div>
                                @endforeach

                                <div class="form-group row">
                                    <x-form.label for="correct_answer" class="col-md-3">
                                        {{ __('Correct answer') }}
                                    </x-form.label>
                                    <div class="col-md-9">
                                        <select name="correct_answer" id="correct_answer" class="form-select">
                                            @if (isset($entry))
                                                @foreach ($entry->answers as $index => $answer)
                                                    <option value="{{ $answer->id }}"{{ old('correct_answer') === $answer->id || $answer->is_correct ? ' selected': '' }}>
                                                        {{ __('Variant :x', ['x' => strtoupper(['a', 'b', 'c', 'd'][$index])]) }}
                                                    </option>
                                                @endforeach
                                            @else
                                                @foreach (['a', 'b', 'c', 'd'] as $index => $variant)
                                                    <option value="{{ $index + 1 }}" {{ old('correct_answer') === $index + 1 ? 'selected' : null }}>
                                                        {{ __('Variant :x', ['x' => strtoupper(['a', 'b', 'c', 'd'][$index])]) }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-slot:body>

                    <x-slot:footer>
                        <x-form.actions :back="route('admin.olympiad.question.list', $olympiadId)"/>
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
        $(function () {
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

            @isset($entry)
            $('fieldset').addClass('d-none');
                @if ($entry->type === Question::TYPE_IMAGE)
                $('fieldset#type-{{ Question::TYPE_IMAGE }}').removeClass('d-none');
                @elseif ($entry->type === Question::TYPE_DOCUMENT)
                $('fieldset#type-{{ Question::TYPE_DOCUMENT  }}').removeClass('d-none');
                @endif
            @endif

            $('#type').on('change', function (e) {
                let type = $(this).val();

                $('fieldset').addClass('d-none');
                $('fieldset#type-' + type).removeClass('d-none');
            });
        });
    </script>
@endpush
