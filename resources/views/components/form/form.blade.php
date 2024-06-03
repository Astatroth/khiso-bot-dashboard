<form {{ $attributes->merge(['class' => 'dmitrix-form', 'id' => uniqid('form_')]) }} action="{{ $action }}" method="{{ $method }}" @if ($files) enctype="multipart/form-data" @endif>
    @csrf
    {{ $slot }}
</form>
