<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Courses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <a href="{{ route('courses.create') }}" class="btn btn-primary mb-4">Add Course</a>

                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <td class="border px-4 py-2">{{ $course->id }}</td> <!-- Use the ID -->
                                <td class="border px-4 py-2">{{ $course->name }}</td>
                                <td class="border px-4 py-2">{{ ucfirst($course->status) }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('courses.showLessons', $course->id) }}" class="btn btn-primary">Lessons</a>
                                    <a href="{{ route('courses.show', $course) }}" class="btn btn-info">View</a>
                                    <a href="{{ route('courses.edit', $course) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('courses.destroy', $course) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $courses->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
