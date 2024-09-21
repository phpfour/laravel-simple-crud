<?php declare(strict_types=1);

namespace Emran\SimpleCRUD;

use Emran\SimpleCRUD\Fields\Field;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;

abstract class CrudResource
{
    protected string $model;
    protected SimpleCRUD $crud;

    public function __construct(SimpleCRUD $crud)
    {
        $this->crud = $crud;
        $this->crud->setModel($this->model);
    }

    /** @return array<int, \Emran\SimpleCRUD\Fields\Field> */
    abstract public function fields(): array;

    public function model(): string
    {
        return $this->model;
    }

    /** @return array<string, array<int, string>> */
    public function rules(string $requestType = 'create'): array
    {
        return collect($this->fields())
            ->mapWithKeys(function (Field $field) use ($requestType): array {
                return [$field->column => $field->getValidationRules($requestType)];
            })
            ->all();
    }

    public function renderForm(?Model $model = null): string
    {
        return View::make('simple-crud::form', [
            'model' => $model,
            'fields' => $model ? $this->updateFields() : $this->creationFields(),
            'crud' => $this->crud,
        ])->render();
    }

    /** @return \Illuminate\Support\Collection<int, \Emran\SimpleCRUD\Fields\Field> */
    public function indexFields(): Collection
    {
        return collect($this->fields())->filter(fn(Field $field): bool => $field->isShownOnIndex());
    }

    /** @return \Illuminate\Support\Collection<int, \Emran\SimpleCRUD\Fields\Field> */
    public function detailFields(): Collection
    {
        return collect($this->fields())->filter(fn(Field $field): bool => $field->isShownOnDetail());
    }

    /** @return \Illuminate\Support\Collection<int, \Emran\SimpleCRUD\Fields\Field> */
    public function creationFields(): Collection
    {
        return collect($this->fields())->filter(fn(Field $field): bool => $field->isShownOnCreate());
    }

    /** @return \Illuminate\Support\Collection<int, \Emran\SimpleCRUD\Fields\Field> */
    public function updateFields(): Collection
    {
        return collect($this->fields())->filter(fn(Field $field): bool => $field->isShownOnUpdate());
    }
}
