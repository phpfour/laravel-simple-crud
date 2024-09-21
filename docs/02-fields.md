# Fields

### Defining Fields

Each SimpleCRUD resource contains a `fields` method. This method returns an array of fields, which generally extend the Emran\SimpleCRUD\Fields\Field class. SimpleCRUD ships with a variety of fields out of the box, including fields for text inputs, booleans, dates, file uploads, Markdown, and more.

To add a field to a resource, you may simply add it to the resource's `fields` method. Typically, fields may be created using their static `make` method. This method accepts several arguments; however, you usually only need to pass the "human-readable" name of the field. SimpleCRUD will automatically "snake case" this string to determine the underlying database column:

```php
use Emran\SimpleCRUD\Fields\ID;
use Emran\SimpleCRUD\Fields\Text;

/**
 * Get the fields displayed by the resource.
 *
 * @param  \Emran\SimpleCRUD\Http\Requests\SimpleCrudRequest  $request
 * @return array
 */
public function fields(NovaRequest $request)
{
    return [
        ID::make()->sortable(),
        Text::make('Name')->sortable(),
    ];
}
```

### Field Column Conventions
As noted above, SimpleCRUD will "snake case" the displayable name of the field to determine the underlying database column. However, if necessary, you may pass the column name as the second argument to the field's make method:

```php
Text::make('Name', 'name_column'),
```

If the field has a JSON, ArrayObject, or array cast assigned to it, you may use the -> operator to specify nested properties within the field:

```php
Timezone::make('User Timezone', 'settings->timezone'),
```

### Showing / Hiding Fields

Often, you will only want to display a field in certain situations. For example, there is typically no need to show a Password field on a resource index listing. Likewise, you may wish to only display a Created At field on the creation / update forms. SimpleCRUD makes it a breeze to hide / show fields on certain pages.

The following methods may be used to show / hide fields based on the display context:

- `showOnIndex`
- `showOnDetail`
- `showOnCreating`
- `showOnUpdating`
- `showOnPreview`
- `showWhenPeeking`
- `hideFromIndex`
- `hideFromDetail`
- `hideWhenCreating`
- `hideWhenUpdating`
- `onlyOnIndex`
- `onlyOnDetail`
- `onlyOnForms`
- `exceptOnForms`

You may chain any of these methods onto your field's definition in order to instruct SimpleCRUD where the field should be displayed:

```php
Text::make('Name')->hideFromIndex(),
```

Alternatively, you may pass a callback to the following methods.

- `showOnIndex`
- `showOnDetail`
- `showOnCreating`
- `showOnUpdating`
- `showWhenPeeking`
- `hideFromIndex`
- `hideFromDetail`
- `hideWhenCreating`
- `hideWhenUpdating`
- `showOnPreview`
- `onlyOnPreview`

For `show*` methods, the field will be displayed if the given callback returns true:

```php
Text::make('Name')->showOnIndex(function (SimpleCrudRequest $request, $resource) {
    return $this->name === 'Taylor Otwell';
}),
```

For hide* methods, the field will be hidden if the given callback returns true:

```php
Text::make('Name')->hideFromIndex(function (SimpleCrudRequest $request, $resource) {
    return $this->name === 'Taylor Otwell';
}),
```

### Default Values
There are times you may wish to provide a default value to your fields. SimpleCRUD offers this functionality via the default method, which accepts a value or callback. This value will be used as the field's default input value on the resource's creation view:

```php
BelongsTo::make('Name')->default($request->user()->getKey()),

Text::make('Uuid')->default(function ($request) {
    return Str::orderedUuid();
}),
```

### Field Placeholder Text
By default, the placeholder text of a field will be it's name. You can override the placeholder text of a field that supports placeholders by using the placeholder method:

```php
Text::make('Name')->placeholder('My New Post'),
```

### Sortable Fields
When attaching a field to a resource, you may use the sortable method to indicate that the resource index may be sorted by the given field:

```php
Text::make('Name', 'name_column')->sortable(),
```

### Field Types
SimpleCRUD ships with a variety of field types. So, let's explore all the available types and their options:

- Boolean
- Date
- Hidden
- ID
- Select
- Text
- Textarea

## Boolean Field
The Boolean field may be used to represent a boolean / "tiny integer" column in your database. For example, assuming your database has a boolean column named active, you may attach a Boolean field to your resource like so:

```php
use Emran\SimpleCRUD\Fields\Boolean;

Boolean::make('Active'),
```

#### Customizing True / False Values
If you are using values other than true, false, 1, or 0 to represent "true" and "false", you may instruct SimpleCRUD to use the custom values recognized by your application. To accomplish this, chain the trueValue and falseValue methods onto your field's definition:

```php
Boolean::make('Active')
    ->trueValue('On')
    ->falseValue('Off'),
```

## Date Field
The Date field may be used to store a date value (without time). For more information about dates and timezones within Nova, check out the additional date / timezone documentation:

```php
use Emran\SimpleCRUD\Fields\Date;

Date::make('Birthday'),
```

## DateTime Field
The DateTime field may be used to store a date-time value. For more information about dates and timezones within Nova, check out the additional date / timezone documentation:

```php
use Emran\SimpleCRUD\Fields\DateTime;

DateTime::make('Updated At')->hideFromIndex(),
```

## Hidden Field
The Hidden field may be used to pass any value that doesn't need to be changed by the user but is required for saving the resource:

```php
Hidden::make('Slug'),

Hidden::make('Slug')->default(Str::random(64)),
```

Combined with default values, Hidden fields are useful for passing things like related IDs to your forms:

```php
Hidden::make('User', 'user_id')->default(function ($request) {
    return $request->user()->id;
}),
```

## ID Field
The ID field represents the primary key of your resource's database table. Typically, each SimpleCRUD resource you define should contain an ID field. By default, the ID field assumes the underlying database column is named id; however, you may pass the column name as the second argument to the make method if necessary:

```php
use Emran\SimpleCRUD\Fields\ID;

ID::make(),

ID::make('ID', 'id_column'),
```

If your application contains very large integer IDs, you may need to use the asBigInt method in order for the SimpleCRUD client to correctly render the integer:

```php
ID::make()->asBigInt(),
```

## Select Field
The Select field may be used to generate a drop-down select menu. The Select menu's options may be defined using the options method:

```php
use Emran\SimpleCRUD\Fields\Select;

Select::make('Size')->options([
    'S' => 'Small',
    'M' => 'Medium',
    'L' => 'Large',
]),
```
On the resource index and detail pages, the Select field's "key" value will be displayed. If you would like to display the labels instead, you may use the displayUsingLabels method:

```php
Select::make('Size')->options([
    'S' => 'Small',
    'M' => 'Medium',
    'L' => 'Large',
])->displayUsingLabels(),
```

You may also display Select options in groups by providing an array structure that contains keys and label / group pairs:

```php
Select::make('Size')->options([
    'MS' => ['label' => 'Small', 'group' => 'Men Sizes'],
    'MM' => ['label' => 'Medium', 'group' => 'Men Sizes'],
    'WS' => ['label' => 'Small', 'group' => 'Women Sizes'],
    'WM' => ['label' => 'Medium', 'group' => 'Women Sizes'],
])->displayUsingLabels(),
```

If you need more control over the generation of the Select field's options, you may provide a closure to the options method:

```php
Select::make('Size')->options(function () {
    return array_filter([
        Size::SMALL => Size::MAX_SIZE === SIZE_SMALL ? 'Small' : null,
        Size::MEDIUM => Size::MAX_SIZE === SIZE_MEDIUM ? 'Medium' : null,
        Size::LARGE => Size::MAX_SIZE === SIZE_LARGE ? 'Large' : null,
    ]);
}),
```
#### Searchable Select Fields
At times it's convenient to be able to search or filter the list of options available in a Select field. You can enable this by invoking the searchable method on the field:

```php
Select::make('Size')->searchable()->options([
    'S' => 'Small',
    'M' => 'Medium',
    'L' => 'Large',
])->displayUsingLabels(),
```

After marking a select field as searchable, SimpleCRUD will display an input field which allows you to filter the list of options based on its label.

## Text Field
The Text field provides an input control with a type attribute of text:

```php
use Emran\SimpleCRUD\Fields\Text;

Text::make('Name'),
```

Text fields may be further customized by setting any attribute on the field. This can be done by calling the withMeta method and providing an extraAttributes array containing key / value pairs of HTML attributes:

```php
Text::make('Name')->withMeta([
    'extraAttributes' => [
        'placeholder' => 'David Hemphill',
    ],
]),
```
#### Formatting Text as Links
To format a Text field as a link, you may invoke the asHtml method when defining the field:

```php
Text::make('Twitter Profile', function () {
    $username = $this->twitterUsername;
    return "<a href='https://twitter.com/{$username}'>@{$username}</a>";
})->asHtml(),
```

#### Setting maxlength on Text Fields
You may wish to indicate to the user that the content of a Text field should be kept within a certain length. You can do this by using the maxlength method on the field:

```php
use Emran\SimpleCRUD\Fields\Text;

Text::make('Name')->maxlength(250),
```

## Textarea Field
The Textarea field provides a textarea control:

```php
use Emran\SimpleCRUD\Fields\Textarea;

Textarea::make('Biography'),
```
By default, Textarea fields will not display their content when viewing a resource's detail page. Instead, the contents of the field will be hidden behind a "Show Content" link, which will reveal the content when clicked. However, if you would like, you may specify that the Textarea field should always display its content by invoking the alwaysShow method on the field:

```php
Textarea::make('Biography')->alwaysShow(),
```
You may specify the Textarea height by invoking the rows method on the field:

```php
Textarea::make('Excerpt')->rows(3),
```
Textarea fields may be further customized by setting any attribute on the field. This can be done by calling the withMeta method and providing an extraAttributes array containing key / value pairs of HTML attributes:

```php
Textarea::make('Excerpt')->withMeta(['extraAttributes' => [
    'placeholder' => 'Make it less than 50 characters']
]),
```

#### Setting maxlength on Textarea Fields
You may wish to indicate to the user that the content of a Textarea field should be kept within a certain length. You can do this by using the maxlength method on the field:

```php
use Emran\SimpleCRUD\Fields\Textarea;

Textarea::make('Name')->maxlength(250),
```

### Computed Fields
In addition to displaying fields that are directly associated with columns in your database, SimpleCRUD allows you to create "computed fields". Computed fields may be used to display computed values that are not associated with a database column. Since they are not associated with a database column, computed fields may not be sortable. These fields may be created by passing a callable (instead of a column name) as the second argument to the field's make method:

```php
Text::make('Name', function () {
    return $this->first_name.' '.$this->last_name;
}),
```
The model instance will be passed to the computed field callable, allowing you to access the model's properties while computing the field's value:

```php
Text::make('Name', function ($model) {
    return $model->first_name.' '.$model->last_name;
}),
```

### Customizations

#### Readonly Fields
There are times where you may want to allow the user to only create and update certain fields on a resource. You can mark fields as "read only" by invoking the readonly method on the field, which will disable the field's corresponding input. You may pass a boolean argument to the readonly method to dynamically control whether a field should be "read only":

```php
Text::make('Email')->readonly(true),
```
You may also pass a closure to the readonly method, and the result of the closure will be used to determine if the field should be "read only". The closure will receive the current SimpleCrudRequest as its first argument:

```php
Text::make('Email')->readonly(function ($request) {
    return ! $request->user()->isAdmin();
}),
```

#### Required Fields
By default, SimpleCRUD will use a red asterisk to indicate a field is required:

SimpleCRUD does this by looking for the required rule inside the field's validation rules to determine if it should show the required state. For example, a field with the following definition would receive a "required" indicator:

```php
Text::make('Email')->rules('required'),
```

When you have complex required validation requirements, you can manually mark the field as required by passing a boolean to the required method when defining the field. This will inform SimpleCRUD that a "required" indicator should be shown in the UI:

```php
Text::make('Email')->required(true),
```

In addition, you may also pass a closure to the required method to determine if the field should be marked as required. The closure will receive an instance of SimpleCrudRequest. The value returned by the closure will be used to determine if field is required:

```php
use Illuminate\Validation\Rule;

Text::make('Email')->required(function ($request) {
    return $this->notify_via_email;
}),
```

#### Nullable Fields
By default, SimpleCRUD attempts to store all fields with a value, however, there are times where you may prefer that Nova store a null value in the corresponding database column when the field is empty. To accomplish this, you may invoke the nullable method on your field definition:

```php
Text::make('Position')->nullable(),
```

#### Field Help Text
If you would like to place "help" text beneath a field, you may invoke the help method when defining your field:

```php
Text::make('Tax Rate')->help(
    'The tax rate to be applied to the sale'
),
```
If necessary, you may include HTML within your field's help text to further customize the help text:

```php
Text::make('First Name')->help(
    '<a href="#">External Link</a>'
),

Text::make('Last Name')->help(
    view('partials.help-text', ['name' => $this->name])->render()
),
```

#### Full Width Fields
You may indicate that the field should be "full width" using the fullWidth method:

```php
Text::make('Content')->fullWidth(),
```

#### Field Text Alignment
You may change the text alignment of fields using the textAlign method:

```php
Text::make('Phone Number')->textAlign('left'),
```
The following alignments are valid:

- left
- center
- right

#### Field Resolution / Formatting
The resolveUsing method allows you to customize how a field is formatted after it is retrieved from your database but before it is sent to the Nova front-end. This method accepts a callback which receives the raw value of the underlying database column:

```php
Text::make('Name')->resolveUsing(function ($name) {
    return strtoupper($name);
}),
```

If you would like to customize how a field is formatted only when it is displayed on a resource's "index" or "detail" pages, you may use the displayUsing method. Like the resolveUsing method, this method accepts a single callback:

```php
Text::make('Name')->displayUsing(function ($name) {
    return strtoupper($name);
}),
```

### Filterable Fields 
The filterable method allows you to enable convenient, automatic filtering functionality for a given field on resources, relationships, and lenses. The SimpleCRUD generated filter will automatically be made available via the resource filter menu on the resource's index:

```php
DateTime::make('Created At')->filterable(),
```

The filterable method also accepts a closure as an argument. This closure will receive the filter query, which you may then customize in order to filter the resource results to your liking:

```php
Text::make('Email')->filterable(function ($request, $query, $value, $attribute) {
    $query->where($attribute, 'LIKE', "{$value}%");
}),
```

The generated filter will be a text filter, select filter, number range filter, or date range filter depending on the underlying field type that was marked as filterable.
