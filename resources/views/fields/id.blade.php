<x-simple-crud::field-wrapper :name="$name" :column="$column" :labelClass="$labelClass" :errorClass="$errorClass">
    <input
        type="text"
        id="{{ $column }}"
        name="{{ $column }}"
        value="{{ $value }}"
        class="{{ $inputClass }}"
        readonly
    >
</x-simple-crud::field-wrapper>
