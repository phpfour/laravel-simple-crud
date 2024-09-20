<?php declare(strict_types=1);

namespace Emran\SimpleCRUD\Http\Controllers;

use Emran\SimpleCRUD\SimpleCRUD;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

abstract class CrudController extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    protected SimpleCRUD $crud;

    public function __construct(SimpleCRUD $crud)
    {
        $this->crud = $crud;
        $this->setup();
    }

    abstract public function setup(): void;

    public function index(): View
    {
        $items = $this->crud->paginate();
        return view('simple-crud::index', [
            'items' => $items,
            'crud' => $this->crud,
            'title' => class_basename($this->crud->getModel()),
        ]);
    }

    public function create(): View
    {
        return view('simple-crud::create', [
            'crud' => $this->crud,
            'title' => class_basename($this->crud->getModel()),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate($this->crud->getValidationRules('create'));
        $item = $this->crud->create($validatedData);
        return redirect()->route($this->crud->getRoute('index'))
            ->with('success', class_basename($this->crud->getModel()).' created successfully.');
    }

    public function show(int|string $id): View
    {
        $item = $this->crud->find($id);
        return view('simple-crud::show', [
            'item' => $item,
            'crud' => $this->crud,
            'title' => class_basename($this->crud->getModel()),
        ]);
    }

    public function edit(int|string $id): View
    {
        $item = $this->crud->find($id);
        return view('simple-crud::edit', [
            'item' => $item,
            'crud' => $this->crud,
            'title' => class_basename($this->crud->getModel()),
        ]);
    }

    public function update(Request $request, int|string $id): RedirectResponse
    {
        $validatedData = $request->validate($this->crud->getValidationRules('update'));
        $this->crud->update($id, $validatedData);
        return redirect()->route($this->crud->getRoute('index'))
            ->with('success', class_basename($this->crud->getModel()).' updated successfully.');
    }

    public function destroy(int|string $id): RedirectResponse
    {
        $this->crud->delete($id);
        return redirect()->route($this->crud->getRoute('index'))
            ->with('success', class_basename($this->crud->getModel()).' deleted successfully.');
    }
}
