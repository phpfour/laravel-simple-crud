<?php declare(strict_types=1);

namespace Emran\SimpleCRUD;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class SimpleCRUD
{
    /** @var class-string<\Illuminate\Database\Eloquent\Model> */
    protected string $model;
    protected string $route;
    protected CrudResource $resource;
    protected Theme $theme;

    public function __construct()
    {
        $this->theme = new Theme();
    }

    public function getTheme(): Theme
    {
        return $this->theme;
    }

    /** @param class-string<\Illuminate\Database\Eloquent\Model> $model */
    public function setModel(string $model): self
    {
        if (!is_subclass_of($model, Model::class)) {
            throw new \InvalidArgumentException('The provided class must be a subclass of '.Model::class);
        }

        $this->model = $model;
        return $this;
    }

    /** @return class-string<\Illuminate\Database\Eloquent\Model> */
    public function getModel(): string
    {
        return $this->model;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;
        return $this;
    }

    public function setResource(CrudResource $resource): self
    {
        $this->resource = $resource;
        return $this;
    }

    /** @return \Illuminate\Pagination\LengthAwarePaginator<\Illuminate\Database\Eloquent\Model> */
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->query()->paginate($perPage);
    }

    public function create(array $data): Model
    {
        return $this->query()->create($data);
    }

    public function find(int|string $id): ?Model
    {
        return $this->query()->find($id);
    }

    public function update(int|string $id, array $data): bool
    {
        $model = $this->find($id);
        return $model ? $model->update($data) : false;
    }

    public function delete(int|string $id): bool
    {
        $model = $this->find($id);
        return $model ? $model->delete() : false;
    }

    public function getRoute(string $action): string
    {
        return "{$this->route}.{$action}";
    }

    public function getFormAction(?Model $model = null): string
    {
        return $model
            ? route($this->getRoute('update'), $model->getKey())
            : route($this->getRoute('store'));
    }

    public function getFormMethod(?Model $model = null): string
    {
        return $model ? 'PUT' : 'POST';
    }

    public function renderForm(?Model $model = null): string
    {
        return $this->resource->renderForm($model);
    }

    /** @return array<string, array<int, string>> */
    public function getValidationRules(string $requestType = 'create'): array
    {
        return $this->resource->rules($requestType);
    }

    /** @return array<int, \Emran\SimpleCRUD\Fields\Field> */
    public function getIndexFields(): array
    {
        return $this->resource->indexFields()->all();
    }

    /** @return array<int, \Emran\SimpleCRUD\Fields\Field> */
    public function getDetailFields(): array
    {
        return $this->resource->detailFields()->all();
    }

    /** @return array<int, \Emran\SimpleCRUD\Fields\Field> */
    public function getCreationFields(): array
    {
        return $this->resource->creationFields()->all();
    }

    /** @return array<int, \Emran\SimpleCRUD\Fields\Field> */
    public function getUpdateFields(): array
    {
        return $this->resource->updateFields()->all();
    }

    /**
     * Get a new query builder for the model.
     *
     * @return \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>
     */
    protected function query(): Builder
    {
        return $this->model::query();
    }
}
