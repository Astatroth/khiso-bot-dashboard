<div {{ $attributes->merge(['class' => 'intl-phone-input']) }}>
    <input type="tel" name="{{ $name }}" class="form-control" value="{{ old($name) }}" id="phone-intl" data-recaptcha-id>
    {{ $slot }}
</div>

@push('styles')
    <link rel="stylesheet" href="{{ vendor('intl-tel-input/css/intlTelInput.min.css') }}">
    <style>
        .iti__flag {background-image: url("{{ vendor('intl-tel-input/img/flags.png') }}");}

        .intl-phone-input .input-group-text {
            position: absolute;
            top: 0;
            right: 0;
            height: 33px;
            padding-left: .45rem;
        }

        .iti--show-selected-dial-code.iti--show-flags .iti__selected-dial-code {
            font-size: 12px;
        }

        @media (min-resolution: 2x) {
            .iti__flag {background-image: url("{{ vendor('intl-tel-input/img/flags@2x.png') }}");}
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ vendor('intl-tel-input/js/intlTelInput.min.js') }}"></script>
    <script>
        $(function () {
            intlTelInput(document.querySelector('#phone-intl'), {
                utilsScript: '{{ vendor('intl-tel-input/js/utils.js') }}',
                autoPlaceholder: 'aggressive',
                initialCountry: '{{ config('intl.default_country') }}',
                showSelectedDialCode: true,
                nationalMode: false,
                hiddenInput: () => 'phone'
            });
        });
    </script>
@endpush
