@extends(config('simple-crud.layout'))

@section(config('simple-crud.content_section'))
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="mb-6">
            <h1 class="text-3xl font-bold mb-2">{{ $title }}</h1>
            <p class="text-gray-600">Details of the {{ strtolower($title) }}.</p>
        </div>

        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="p-6 space-y-6">
                @foreach($crud->getDetailFields() as $field)
                    <div class="border-b border-gray-200 pb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ $field->name }}
                        </label>
                        <div class="mt-1 text-sm text-gray-900">
                            {!! $field->renderForDetail($item->{$field->column}) !!}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-6 flex justify-between">
            <div>
                <a href="{{ route($crud->getRoute('edit'), $item->getKey()) }}" class="{{ config('simple-crud.theme.button') }} bg-blue-500 hover:bg-blue-600">
                    Edit
                </a>
                <a href="{{ route($crud->getRoute('index')) }}" class="{{ config('simple-crud.theme.button') }} bg-gray-500 hover:bg-gray-600 ml-2">
                    Back to List
                </a>
            </div>
            <form action="{{ route($crud->getRoute('destroy'), $item->getKey()) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="{{ config('simple-crud.theme.button') }} bg-red-500 hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this item?')">
                    Delete
                </button>
            </form>
        </div>
    </div>
@endsection
