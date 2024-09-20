<?php declare(strict_types=1);

namespace Emran\SimpleCRUD\Fields;

class ID extends Field
{
    public function __construct(string $name = 'ID', ?string $column = 'id')
    {
        parent::__construct($name, $column);

        $this->sortable();
    }

    public static function make(string $name = 'ID', ?string $column = 'id'): self
    {
        return new static($name, $column);
    }

    public function render(?string $value = null): string
    {
        return view('simple-crud::fields.id', [
            'name' => $this->name,
            'column' => $this->column,
            'value' => $value,
            'inputClass' => $this->getInputClass(),
            'labelClass' => $this->getLabelClass(),
            'errorClass' => $this->getErrorClass(),
        ])->render();
    }

    /** @return array<int, string> */
    public function getValidationRules(string $requestType = 'create'): array
    {
        $rules = parent::getValidationRules($requestType);

        if ($requestType === 'update') {
            $rules[] = 'sometimes';
        }

        return $rules;
    }
}
