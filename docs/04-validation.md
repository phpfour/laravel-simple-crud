# Validation
Unless you like to live dangerously, any Nova fields that are displayed on the Nova creation / update pages will need some validation. Thankfully, it's a cinch to attach all of the Laravel validation rules you're familiar with to your Nova resource fields. Let's get started.

### Attaching Rules
When defining a field on a resource, you may use the rules method to attach validation rules to the field:

```php
Text::make('Name')
    ->sortable()
    ->rules('required', 'max:255'),
```

Of course, if you are leveraging Laravel's support for validation rule objects, you may attach those to resources as well:

```php
use App\Rules\ValidState;

Text::make('State')
    ->sortable()
    ->rules('required', new ValidState),
```

You may also provide rules to the rules method via an array or Closure:

```php
// Using an array...
Text::make('State')->rules(['required', new ValidState]),

// Using a Closure...
Text::make('State')->rules(fn ($request) => [
    'required',
    new ValidState(),
]);
```

### Creation/Update Rules
If you would like to define rules that only apply when a resource is being created, you may use the creationRules method:

```php
Text::make('Email')
    ->sortable()
    ->rules('required', 'email', 'max:255')
    ->creationRules('unique:users,email'),
```
Likewise, if you would like to define rules that only apply when a resource is being updated, you may use the updateRules method. If necessary, you may use resourceId place-holder within your rule definition. This place-holder will automatically be replaced with the primary key of the resource being updated:

```php
Text::make('Email')
    ->sortable()
    ->rules('required', 'email', 'max:255')
    ->creationRules('unique:users,email')
    ->updateRules('unique:users,email,{{resourceId}}'),
```
