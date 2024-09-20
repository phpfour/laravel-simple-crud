<x-simple-crud::field-wrapper :name="$name" :column="$column" :labelClass="$labelClass" :errorClass="$errorClass">
    <select
        id="{{ $column }}"
        name="{{ $column }}{{ $multiple ? '[]' : '' }}"
        class="{{ $inputClass }}"
        {{ $multiple ? 'multiple' : '' }}
    >
        @foreach($options as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</x-simple-crud::field-wrapper>
