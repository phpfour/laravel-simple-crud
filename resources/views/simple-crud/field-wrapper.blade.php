<div>
    <label for="{{ $column }}" class="{{ $labelClass }}">
        {{ Str::title($name) }}
    </label>

    {{ $slot }}

    @error($column)
        <p class="{{ $errorClass }}">{{ $message }}</p>
    @enderror
</div>
