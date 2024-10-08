<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Course') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Course Name -->
                    <div class="form-group mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Course Name</label>
                        <input type="text" name="name" id="name" class="form-control mt-1 block w-full" value="{{ old('name', $course->name) }}" required>
                    </div>

                    <!-- Course Description -->
                    <div class="form-group mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" class="form-control mt-1 block w-full">{{ old('description', $course->description) }}</textarea>
                    </div>

                    <!-- Original Price -->
                    <div class="form-group mb-4">
                        <label for="original_price" class="block text-sm font-medium text-gray-700">Original Price</label>
                        <input type="number" step="0.01" name="original_price" id="original_price" class="form-control mt-1 block w-full" value="{{ old('original_price', $course->original_price) }}" required>
                    </div>

                    <!-- Discount Price -->
                    <div class="form-group mb-4">
                        <label for="discount_price" class="block text-sm font-medium text-gray-700">Discount Price</label>
                        <input type="number" step="0.01" name="discount_price" id="discount_price" class="form-control mt-1 block w-full" value="{{ old('discount_price', $course->discount_price) }}">
                    </div>

                    <!-- Start Date -->
                    <div class="form-group mb-4">
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" id="start_date" class="form-control mt-1 block w-full" value="{{ old('start_date', $course->start_date) }}" required>
                    </div>

                    <!-- Duration -->
                    <div class="form-group mb-4">
                        <label for="duration" class="block text-sm font-medium text-gray-700">Duration</label>
                        <input type="text" name="duration" id="duration" class="form-control mt-1 block w-full" value="{{ old('duration', $course->duration) }}" required>
                    </div>

                    <!-- Installment Toggle -->
                    <div class="form-group mb-4">
                        <label class="block text-sm font-medium text-gray-700">Allow Installment Payment</label>
                        <input type="checkbox" name="installment" id="installment" {{ $course->installment ? 'checked' : '' }} onchange="toggleInstallments(this)">
                    </div>

                    <!-- Installment Amounts -->
                    <div id="installmentFields" style="{{ $course->installment ? '' : 'display:none;' }}">
                        @for ($i = 1; $i <= 6; $i++)
                            <div class="form-group mb-4">
                                <label for="installment_{{ $i }}" class="block text-sm font-medium text-gray-700">Installment Amount {{ $i }}</label>
                                <input type="number" step="0.01" name="installment_{{ $i }}" id="installment_{{ $i }}" class="form-control mt-1 block w-full" value="{{ old('installment_'.$i, $course->{'installment_'.$i}) }}">
                            </div>
                        @endfor
                    </div>

                    <!-- Course Image -->
                    <div class="form-group mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700">Course Image</label>
                        <input type="file" name="image" id="image" class="form-control mt-1 block w-full">
                        @if ($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}" alt="Course Image" class="mt-2 w-32 h-32">
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary">Update Course</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleInstallments(checkbox) {
            var installmentFields = document.getElementById('installmentFields');
            installmentFields.style.display = checkbox.checked ? 'block' : 'none';
        }
    </script>
</x-app-layout>
