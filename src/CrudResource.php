<?php declare(strict_types=1);

namespace Emran\SimpleCRUD;

use Emran\SimpleCRUD\Fields\Field;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class CrudResource
{
    protected string $model;

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
            ->mapWithKeys(function (Field $field) use ($requestType) {
                return [$field->column => $field->getValidationRules($requestType)];
            })
            ->all();
    }

    public function renderForm(?Model $model = null): string
    {
        $theme = new Theme();

        return view('simple-crud::form', [
            'fields' => $this->fields(),
            'model' => $model,
            'formClass' => $theme->getClass('form'),
            'buttonClass' => $theme->getClass('button'),
        ])->render();
    }

    /** @return \Illuminate\Support\Collection<int, \Emran\SimpleCRUD\Fields\Field> */
    public function indexFields(): Collection
    {
        return collect($this->fields())->filter->showOnIndex;
    }

    /** @return \Illuminate\Support\Collection<int, \Emran\SimpleCRUD\Fields\Field> */
    public function detailFields(): Collection
    {
        return collect($this->fields())->filter->showOnDetail;
    }

    /** @return \Illuminate\Support\Collection<int, \Emran\SimpleCRUD\Fields\Field> */
    public function creationFields(): Collection
    {
        return collect($this->fields())->filter->showOnCreate;
    }

    /** @return \Illuminate\Support\Collection<int, \Emran\SimpleCRUD\Fields\Field> */
    public function updateFields(): Collection
    {
        return collect($this->fields())->filter->showOnUpdate;
    }
}
