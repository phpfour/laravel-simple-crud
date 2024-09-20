<?php declare(strict_types=1);

namespace Emran\SimpleCRUD\Fields;

class Boolean extends Field
{
    protected string $trueValue = '1';
    protected string $falseValue = '0';

    public static function make(string $name, ?string $column = null): self
    {
        return new static($name, $column);
    }

    public function trueValue(string $value): self
    {
        $this->trueValue = $value;
        return $this;
    }

    public function falseValue(string $value): self
    {
        $this->falseValue = $value;
        return $this;
    }

    public function render(?string $value = null): string
    {
        return view('simple-crud::fields.boolean', [
            'name' => $this->name,
            'column' => $this->column,
            'checked' => old($this->column, $value) === $this->trueValue,
            'inputClass' => $this->getInputClass(),
            'labelClass' => $this->getLabelClass(),
            'errorClass' => $this->getErrorClass(),
            'trueValue' => $this->trueValue,
            'falseValue' => $this->falseValue,
        ])->render();
    }

    /** @return array<int, string> */
    public function getValidationRules(string $requestType = 'create'): array
    {
        $rules = parent::getValidationRules($requestType);
        $rules[] = 'boolean';
        return $rules;
    }
}
