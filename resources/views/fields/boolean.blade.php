<x-simple-crud::field-wrapper :name="$name" :column="$column" :labelClass="$labelClass" :errorClass="$errorClass">
    <div class="flex items-center">
        <input
            type="checkbox"
            id="{{ $column }}"
            name="{{ $column }}"
            value="{{ $trueValue }}"
            @if($checked) checked @endif
            class="{{ $inputClass }}"
        >
        <label for="{{ $column }}" class="ml-2">{{ $name }}</label>
    </div>
    <input type="hidden" name="{{ $column }}" value="{{ $falseValue }}">
</x-simple-crud::field-wrapper>
