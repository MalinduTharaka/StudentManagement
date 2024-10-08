<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Lesson to ' . $course->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('courses.storeLesson', $course->id) }}" method="POST">
                    @csrf

                    <!-- Lesson Name -->
                    <div class="form-group mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Lesson Name</label>
                        <input type="text" name="name" id="name" class="form-control mt-1 block w-full" required>
                    </div>

                    <!-- Lesson Description -->
                    <div class="form-group mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" class="form-control mt-1 block w-full"></textarea>
                    </div>

                    <!-- YouTube Link -->
                    <div class="form-group mb-4">
                        <label for="youtube_link" class="block text-sm font-medium text-gray-700">YouTube Link</label>
                        <input type="url" name="youtube_link" id="youtube_link" class="form-control mt-1 block w-full">
                    </div>

                    <!-- Other Link -->
                    <div class="form-group mb-4">
                        <label for="other_link" class="block text-sm font-medium text-gray-700">Other Link</label>
                        <input type="url" name="other_link" id="other_link" class="form-control mt-1 block w-full">
                    </div>

                    <!-- Status -->
                    <div class="form-group mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Active</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Add Lesson</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
