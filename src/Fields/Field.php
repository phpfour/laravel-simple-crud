<?php declare(strict_types=1);

namespace Emran\SimpleCRUD\Fields;

use Emran\SimpleCRUD\Theme;
use Illuminate\Support\Str;

abstract class Field
{
    public string $name;
    public string $column;

    /** @var array<int, string> */
    protected array $rules = [];

    /** @var array<int, string>|null */
    protected ?array $creationRules = null;

    /** @var array<int, string>|null */
    protected ?array $updateRules = null;

    protected bool $sortable = false;
    protected bool $showOnIndex = true;
    protected bool $showOnDetail = true;
    protected bool $showOnCreate = true;
    protected bool $showOnUpdate = true;
    protected Theme $theme;

    public function __construct(string $name, ?string $column = null)
    {
        $this->name = $name;
        $this->column = $column ?? Str::snake($name);
        $this->theme = new Theme();
    }

    abstract public function render(?string $value = null): string;

    public function renderForIndex(?string $value = null): string
    {
        return htmlspecialchars((string) $value);
    }

    public function renderForDetail(?string $value = null): string
    {
        return htmlspecialchars((string) $value);
    }

    public function rules(string ...$rules): self
    {
        $this->rules = array_merge($this->rules, $rules);
        return $this;
    }

    public function creationRules(string ...$rules): self
    {
        $this->creationRules = array_merge($this->creationRules ?? [], $rules);
        return $this;
    }

    public function updateRules(string ...$rules): self
    {
        $this->updateRules = array_merge($this->updateRules ?? [], $rules);
        return $this;
    }

    public function sortable(bool $sortable = true): self
    {
        $this->sortable = $sortable;
        return $this;
    }

    public function hideFromIndex(): self
    {
        $this->showOnIndex = false;
        return $this;
    }

    public function hideFromDetail(): self
    {
        $this->showOnDetail = false;
        return $this;
    }

    public function hideWhenCreating(): self
    {
        $this->showOnCreate = false;
        return $this;
    }

    public function hideWhenUpdating(): self
    {
        $this->showOnUpdate = false;
        return $this;
    }

    /** @return array<int, string> */
    public function getValidationRules(string $requestType = 'create'): array
    {
        $rules = $this->rules;

        if ($requestType === 'create' && $this->creationRules !== null) {
            $rules = array_merge($rules, $this->creationRules);
        } elseif ($requestType === 'update' && $this->updateRules !== null) {
            $rules = array_merge($rules, $this->updateRules);
        }

        return $rules;
    }

    public function isShownOnIndex(): bool
    {
        return $this->showOnIndex;
    }

    public function isShownOnDetail(): bool
    {
        return $this->showOnDetail;
    }

    public function isShownOnCreate(): bool
    {
        return $this->showOnCreate;
    }

    public function isShownOnUpdate(): bool
    {
        return $this->showOnUpdate;
    }

    protected function getInputClass(): string
    {
        return $this->theme->getClass('input');
    }

    protected function getLabelClass(): string
    {
        return $this->theme->getClass('label');
    }

    protected function getErrorClass(): string
    {
        return $this->theme->getClass('error');
    }
}
