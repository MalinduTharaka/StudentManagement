<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Deleted Lessons (Trash)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Display Deleted Lessons -->
                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Lesson Name</th>
                            <th style="width: 200px" class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deletedLessons as $lesson)
                            <tr>
                                <td class="border px-4 py-2">{{ $lesson->name }}</td>
                                <td class="border px-4 py-2">
                                    <!-- Restore Button -->
                                    <form action="{{ route('lessons.restore', $lesson->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Restore</button>
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
