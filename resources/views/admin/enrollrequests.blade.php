<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Enroll Requests
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Payments Table in Blade File -->
            <!-- Payments Table in Blade File -->
<table class="table-auto w-full">
    <thead>
        <tr>
            <th class="px-4 py-2">Course Name</th>
            <th class="px-4 py-2">Student ID</th>
            <th class="px-4 py-2">Paid Amount</th>
            <th class="px-4 py-2">Payment Slip</th>
            <th class="px-4 py-2">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($payments as $payment)
            <tr>
                <td class="px-4 py-2">{{ $payment->course->name }}</td>
                <td class="px-4 py-2">{{ $payment->user->id }}</td>
                <td class="px-4 py-2">${{ $payment->amount }}</td>
                <td class="px-4 py-2">
                    <!-- View Button to Open Modal -->
                    <button onclick="openModal('{{ asset('storage/' . $payment->payment_slip) }}')" class="btn btn-primary">
                        View
                    </button>
                </td>
                <td class="px-4 py-2 ">
                    <form action="{{ route('enroll.approve', $payment->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-info">Approve</button>
                    </form>
                    <form action="{{ route('enroll.deny', $payment->id) }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="btn btn-danger">Deny</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal for Viewing Payment Slip -->
<div id="imageModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
    <div class="bg-white p-4 rounded-lg">
        <button onclick="closeModal()" class="ml-auto text-gray-600">&times; Close</button>
        <img id="modalImage" src="" alt="Payment Slip" class="max-w-full h-auto mt-4" 
             onerror="this.style.display='none'; document.getElementById('altText').style.display='block';">
        <p id="altText" class="text-center mt-4 text-gray-700" style="display: none;">Payment Slip could not be loaded.</p>
    </div>
</div>

<script>
    function openModal(imageUrl) {
        const modalImage = document.getElementById('modalImage');
        const altText = document.getElementById('altText');
        
        modalImage.src = imageUrl; // Set the image URL
        modalImage.style.display = 'block'; // Ensure the image is set to block (to be visible)
        altText.style.display = 'none'; // Hide the alt text initially
        
        // Show the modal
        document.getElementById('imageModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }
</script>

    
    
</x-app-layout>
