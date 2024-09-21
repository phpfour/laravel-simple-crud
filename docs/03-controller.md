# Controller

SimpleCRUD provides a base controller that you may extend to define the CRUD operations for your resources. This controller provides the typical CRUD operations like `index`, `show`, `store`, `update`, and `destroy`.

### Defining a Controller

To create a new controller, you may use the `make:crud-controller` Artisan command. This command will place a new controller in the `app/Http/Controllers` directory of your application:

```bash
php artisan make:crud-controller PostController
```

The generated controller will look like this:

```php
<?php

namespace App\Http\Controllers;

use App\CrudResources\PostCrudResource;
use Emran\SimpleCRUD\Http\Controllers\CrudController;

class PostController extends CrudController
{
    public function setup()
    {
        $this->crud->setModel(\App\Models\Post::class);
        $this->crud->setRoute(config('simple-crud.route_prefix') . '/posts');
        $this->crudResource = new PostCrudResource($this->crud);
    }
}
```

### Registering a Controller

After creating a controller, you may register it with the Laravel router. You may do this by adding a route to the `routes/web.php` file:

```php
use App\Http\Controllers\PostController;

Route::simpleCrud('posts', PostController::class);
```

### Overriding Controller Methods

You may override any of the controller methods to customize the behavior of the controller. For example, you may override the `store` method to add additional validation before storing a new resource:

```php
public function store(Request $request)
{
    // do something different

    return parent::store($request);
}
```

### Customizing the Controller

You may customize the controller by adding additional methods or properties. For example, you may add a new method to the controller to handle a custom action:

```php
public function publish(Request $request, $id)
{
    $post = Post::findOrFail($id);
    $post->published_at = now();
    $post->save();

    return redirect()->route('posts.index');
}
```
