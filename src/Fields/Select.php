<?php declare(strict_types=1);

namespace Emran\SimpleCRUD\Fields;

use Closure;
use Illuminate\Support\Collection;

class Select extends Field
{
    /** @var array<string, string>|\Illuminate\Support\Collection<string, string> */
    protected array|Collection $options = [];

    protected bool $multiple = false;

    public static function make(string $name, ?string $column = null): self
    {
        return new static($name, $column);
    }

    /** @param array<string, string>|\Illuminate\Support\Collection<string, string>|\Closure $options */
    public function options(array|Collection|Closure $options): self
    {
        $this->options = $options instanceof Closure ? $options() : $options;

        return $this;
    }

    public function multiple(bool $multiple = true): self
    {
        $this->multiple = $multiple;
        return $this;
    }

    public function render(?string $value = null): string
    {
        return view('simple-crud::fields.select', [
            'name' => $this->name,
            'column' => $this->column,
            'options' => $this->options,
            'selected' => old($this->column, $value),
            'inputClass' => $this->getInputClass(),
            'labelClass' => $this->getLabelClass(),
            'errorClass' => $this->getErrorClass(),
            'multiple' => $this->multiple,
        ])->render();
    }

    /** @return array<int, string> */
    public function getValidationRules(string $requestType = 'create'): array
    {
        $rules = parent::getValidationRules($requestType);
        $rules[] = 'in:'.implode(',', array_keys($this->options instanceof Collection ? $this->options->toArray() : $this->options));

        if ($this->multiple) {
            $rules[] = 'array';
        }

        return $rules;
    }
}
