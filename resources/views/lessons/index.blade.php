<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lessons for ' . $course->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                
                <!-- Add Lesson Button -->
                <a href="{{ route('courses.addLesson', $course->id) }}" class="btn btn-primary mb-4">Add Lesson</a>
                <a href="{{ route('lessons.trash') }}" class="btn btn-secondary mb-4">Trash</a>

                <!-- List of Lessons -->
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Lesson Name</th>
                            <th style="width:200px" class="px-4 py-2">Status</th>
                            <th style="width:300px" class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lessons->where('status', '!=', 2) as $lesson)
                            <tr>
                                <td class="border px-4 py-2">{{ $lesson->name }}</td>
                                <td class="border px-4 py-2">{{ $lesson->status ? 'Active' : 'Inactive' }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('lessons.edit', $lesson->id) }}" class="btn btn-warning">Edit</a>
                                    <form action="{{ route('lessons.destroy', $lesson->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
