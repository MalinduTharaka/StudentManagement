<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Lesson: ' . $lesson->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('lessons.update', $lesson->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Lesson Name -->
                    <div class="form-group mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Lesson Name</label>
                        <input type="text" name="name" id="name" class="form-control mt-1 block w-full" value="{{ old('name', $lesson->name) }}" required>
                    </div>

                    <!-- Description -->
                    <div class="form-group mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" class="form-control mt-1 block w-full">{{ old('description', $lesson->description) }}</textarea>
                    </div>

                    <!-- YouTube Link -->
                    <div class="form-group mb-4">
                        <label for="youtube_link" class="block text-sm font-medium text-gray-700">YouTube Link</label>
                        <input type="url" name="youtube_link" id="youtube_link" class="form-control mt-1 block w-full" value="{{ old('youtube_link', $lesson->youtube_link) }}">
                    </div>

                    <!-- Other Link -->
                    <div class="form-group mb-4">
                        <label for="other_link" class="block text-sm font-medium text-gray-700">Other Link</label>
                        <input type="url" name="other_link" id="other_link" class="form-control mt-1 block w-full" value="{{ old('other_link', $lesson->other_link) }}">
                    </div>

                    <!-- Status -->
                    <div class="form-group mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1" {{ $lesson->status ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$lesson->status ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Update Lesson</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
