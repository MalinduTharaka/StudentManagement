<div>
    @if (session()->has('message'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: "{{ session('message') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <div>
        <h2>{{ $updateMode ? 'Edit Course' : 'Add Course' }}</h2>
        <form wire:submit.prevent="{{ $updateMode ? 'update' : 'store' }}">
            <!-- Input fields -->
            <input type="text" wire:model="name" placeholder="Course Name" required>
            <textarea wire:model="description" placeholder="Description" required></textarea>
            <input type="number" wire:model="original_price" placeholder="Original Price" required>
            <input type="number" wire:model="discount_price" placeholder="Discount Price">
            <input type="checkbox" wire:model="allow_installment"> Allow Installments
            @if($allow_installment)
                @for($i = 1; $i <= 6; $i++)
                    <input type="number" wire:model="installments.{{ $i }}" placeholder="Installment {{$i}}">
                @endfor
            @endif
            <input type="date" wire:model="start_date" required>
            <input type="number" wire:model="duration" placeholder="Duration (weeks/months)" required>
            <select wire:model="status">
                <option value="waiting">Waiting</option>
                <option value="ongoing">Ongoing</option>
                <option value="completed">Completed</option>
            </select>
            <input type="checkbox" wire:model="active"> Active
            <button type="submit">{{ $updateMode ? 'Update' : 'Save' }}</button>
        </form>
    </div>

    <div>
        <h2>Course List</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                    <tr>
                        <td>{{ $course->name }}</td>
                        <td>{{ ucfirst($course->status) }}</td>
                        <td>
                            <button wire:click="edit({{ $course->id }})">Edit</button>
                            <button wire:click="delete({{ $course->id }})">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $courses->links() }}
    </div>
</div>
