<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Course Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-xl font-bold">Course Name: {{ $course->name }}</h3>
                <p><strong>Description:</strong> {{ $course->description }}</p>
                <p><strong>Original Price:</strong> {{ $course->original_price }}</p>
                <p><strong>Discount Price:</strong> {{ $course->discount_price ?? 'N/A' }}</p>
                <p><strong>Status:</strong> {{ ucfirst($course->status) }}</p>
                <p><strong>Start Date:</strong> {{ $course->start_date }}</p>
                <p><strong>Duration:</strong> {{ $course->duration }}</p>
                
                <!-- Display created_at and updated_at -->
                <p><strong>Created At:</strong> {{ $course->created_at->format('Y-m-d H:i:s') }}</p>
                <p><strong>Last Updated:</strong> {{ $course->updated_at->format('Y-m-d H:i:s') }}</p>

                <!-- Installment Amounts -->
                @if($course->installment)
                    <h4 class="mt-4 font-bold">Installments:</h4>
                    <p>Installment 1: {{ $course->installment_1 ?? 'N/A' }}</p>
                    <p>Installment 2: {{ $course->installment_2 ?? 'N/A' }}</p>
                    <p>Installment 3: {{ $course->installment_3 ?? 'N/A' }}</p>
                    <p>Installment 4: {{ $course->installment_4 ?? 'N/A' }}</p>
                    <p>Installment 5: {{ $course->installment_5 ?? 'N/A' }}</p>
                    <p>Installment 6: {{ $course->installment_6 ?? 'N/A' }}</p>
                @endif

                @if($course->image)
                    <div class="mt-4">
                        <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->name }}" class="w-64 h-64">
                    </div>
                @endif

                <div class="mt-6">
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
