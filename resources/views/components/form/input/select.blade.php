<select {{ $attributes->class(['form-select', 'is-invalid' => $errors->has($name)])->merge(['required' => $isRequired]) }}>
    {{ $options }}
</select>
