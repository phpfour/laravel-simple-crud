@extends(config('simple-crud.layout'))

@section(config('simple-crud.content_section'))
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Edit {{ $title ?? 'Item' }}</h1>

        <form action="{{ route($crud->getRoute('update'), $item->getKey()) }}" method="POST" class="{{ config('simple-crud.theme.form') }}">
            @csrf
            @method('PUT')

            @foreach($crud->getUpdateFields() as $field)
                <div class="mb-4">
                    {!! $field->render($item->{$field->column}) !!}
                </div>
            @endforeach

            <div class="mt-6">
                <button type="submit" class="{{ config('simple-crud.theme.button') }}">
                    Update
                </button>
                <a href="{{ route($crud->getRoute('index')) }}" class="{{ config('simple-crud.theme.button') }} bg-gray-500 hover:bg-gray-600">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection

@unless(config('simple-crud.layout'))
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Edit {{ $title ?? 'Item' }}</title>

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
    <body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <!-- Navigation content -->
        </nav>

        <!-- Page Content -->
        <main>
            @yield(config('simple-crud.content_section'))
        </main>
    </div>
    </body>
    </html>
@endunless
