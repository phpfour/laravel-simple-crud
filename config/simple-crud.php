<?php declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Route Prefix
    |--------------------------------------------------------------------------
    |
    | This value will be used as the prefix for all SimpleCRUD routes.
    | If you want your CRUD routes to be prefixed with /admin, set this to 'admin'.
    | Set to null or an empty string to use no prefix.
    |
    */
    'route_prefix' => '',

    /*
    |--------------------------------------------------------------------------
    | Theme
    |--------------------------------------------------------------------------
    |
    | Specify the CSS classes to be used for different elements in the CRUD views.
    | You can customize these to match your application's styling.
    |
    */
    'theme' => [
        'form' => 'space-y-6',
        'input' => 'mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50',
        'label' => 'block font-medium text-sm text-gray-700',
        'button' => 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150',
        'error' => 'text-red-600 text-sm mt-1',
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    |
    | Specify the default number of items to show per page in index views.
    |
    */
    'per_page' => 15,

    /*
    |--------------------------------------------------------------------------
    | Resource Namespace
    |--------------------------------------------------------------------------
    |
    | Specify the namespace where your CRUD resources will be stored.
    |
    */
    'resource_namespace' => 'App\\CrudResources',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Specify the layout to be used for the CRUD views. You can set this to
    | null if you want to handle the layout in your own views, or specify
    | a custom layout view path.
    |
    */
    'layout' => null, // Example: 'layouts.app'

    /*
    |--------------------------------------------------------------------------
    | Content Section
    |--------------------------------------------------------------------------
    |
    | If using a layout, specify the section name where the CRUD content
    | should be yielded. This is typically 'content' in many Laravel apps.
    |
    */
    'content_section' => 'content',
];
