<?php declare(strict_types=1);

namespace Emran\SimpleCRUD\Fields;

use Illuminate\Support\Str;

class Text extends Field
{
    protected ?int $maxLength = null;

    public static function make(string $name, ?string $column = null): self
    {
        return new static($name, $column);
    }

    public function renderForIndex(?string $value = null): string
    {
        return Str::limit(htmlspecialchars((string) $value), 50);
    }

    public function renderForDetail(?string $value = null): string
    {
        $value = htmlspecialchars((string) $value);

        if (Str::length($value) > 100) {
            return '<div class="whitespace-pre-wrap">'.nl2br($value).'</div>';
        }

        return $value;
    }

    public function maxLength(int $length): self
    {
        $this->maxLength = $length;
        return $this;
    }

    public function render(?string $value = null): string
    {
        return view('simple-crud::fields.text', [
            'name' => $this->name,
            'column' => $this->column,
            'value' => old($this->column, $value),
            'inputClass' => $this->getInputClass(),
            'labelClass' => $this->getLabelClass(),
            'errorClass' => $this->getErrorClass(),
            'maxLength' => $this->maxLength,
        ])->render();
    }

    /** @return array<int, string> */
    public function getValidationRules(string $requestType = 'create'): array
    {
        $rules = parent::getValidationRules($requestType);

        if ($this->maxLength !== null) {
            $rules[] = 'max:'.$this->maxLength;
        }

        return $rules;
    }
}
