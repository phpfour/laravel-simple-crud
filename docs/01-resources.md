# Resources

### Defining Resources

By default, CRUD resources are stored in the `app/CrudResources` directory of your application. You may generate a new resource using the `make:crud` Artisan command:

```bash
php artisan make:crud Post
```

The most basic and fundamental property of a resource is its model property. This property tells SimpleCRUD which Eloquent model the resource corresponds to:

```php
<?php

namespace App\CrudResources;

use Emran\SimpleCRUD\CrudResource;

class PostCrudResource extends CrudResource
{
    public static $model = 'App\Models\Post';
}
```  
  
Freshly created SimpleCRUD resources only contain an ID field definition. Don't worry, we'll add more fields to our resource soon.
