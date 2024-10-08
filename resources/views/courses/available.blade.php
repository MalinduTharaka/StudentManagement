<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Available Courses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Course Name</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Actions</th>
                            <th class="px-4 py-2">Enroll to course</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <td class="border px-4 py-2">{{ $course->name }}</td>
                                <td class="border px-4 py-2">{{ ucfirst($course->status) }}</td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-info">View Details</a>
                                </td>
                                <td class="border px-4 py-2">
                                    <a href="{{ route('courses.enroll', $course->id) }}" class="btn btn-success">Enroll</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
