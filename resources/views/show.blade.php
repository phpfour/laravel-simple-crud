@extends(config('simple-crud.layout'))

@section(config('simple-crud.content_section'))
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">{{ $title ?? 'Item' }} Details</h1>
            <div>
                <a href="{{ route($crud->getRoute('edit'), $item->getKey()) }}" class="{{ config('simple-crud.theme.button') }} bg-blue-500 hover:bg-blue-600">
                    Edit
                </a>
                <a href="{{ route($crud->getRoute('index')) }}" class="{{ config('simple-crud.theme.button') }} bg-gray-500 hover:bg-gray-600">
                    Back to List
                </a>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <dl class="divide-y divide-gray-200">
                @foreach($crud->getDetailFields() as $field)
                    <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                            {{ $field->name }}
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {!! $field->render($item->{$field->column}) !!}
                        </dd>
                    </div>
                @endforeach
            </dl>
        </div>

        <div class="mt-6">
            <form action="{{ route($crud->getRoute('destroy'), $item->getKey()) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="{{ config('simple-crud.theme.button') }} bg-red-500 hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this item?')">
                    Delete
                </button>
            </form>
        </div>
    </div>
@endsection

@unless(config('simple-crud.layout'))
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - {{ $title ?? 'Item' }} Details</title>

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
