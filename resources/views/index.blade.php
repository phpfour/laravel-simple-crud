@extends(config('simple-crud.layout'))

@section(config('simple-crud.content_section'))
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">{{ $title }}</h1>
            <a href="{{ route($crud->getRoute('create')) }}" class="{{ config('simple-crud.theme.button') }}">
                Create New
            </a>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    @foreach($crud->getIndexFields() as $field)
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ $field->name }}
                        </th>
                    @endforeach
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach($items as $item)
                    <tr>
                        @foreach($crud->getIndexFields() as $field)
                            <td class="px-6 py-4 whitespace-nowrap">
                                {!! $field->renderForIndex($item->{$field->column}) !!}
                            </td>
                        @endforeach
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route($crud->getRoute('show'), $item->getKey()) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">View</a>
                            <a href="{{ route($crud->getRoute('edit'), $item->getKey()) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                            <form action="{{ route($crud->getRoute('destroy'), $item->getKey()) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $items->links() }}
        </div>
    </div>
@endsection
