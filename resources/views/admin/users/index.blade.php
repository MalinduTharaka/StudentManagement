<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Role
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->role }}</td>
                            <td id="status-{{ $user->id }}" class="px-6 py-4 whitespace-nowrap">
                                {{ $user->suspended ? 'Suspended' : 'Active' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button class="btn btn-primary" onclick="changeRole({{ $user->id }}, '{{ $user->role }}')">Change Role</button>
                                
                                <button id="suspend-btn-{{ $user->id }}" class="btn {{ $user->suspended ? 'btn-success' : 'btn-warning' }}"
                                    onclick="suspendUser({{ $user->id }})">
                                    {{ $user->suspended ? 'Activate' : 'Suspend' }}
                                </button>
                                <button class="btn btn-secondary" onclick="resetPassword({{ $user->id }})">Reset Password</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $users->links() }}
            </div>
        </div>
    </div>

    <script>
        function changeRole(userId, currentRole) {
            Swal.fire({
                title: 'Change Role',
                input: 'select',
                inputOptions: {
                    'admin': 'Admin',
                    'staff': 'Staff',
                    'user': 'User',
                },
                inputValue: currentRole,
                showCancelButton: true,
                confirmButtonText: 'Update Role',
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(`/admin/users/${userId}/role`, {
                        role: result.value
                    }).then(response => {
                        Swal.fire('Success', response.data.success, 'success').then(() => {
                            location.reload();
                        });
                    });
                }
            });
        }

        function suspendUser(userId) {
            let button = document.querySelector(`#suspend-btn-${userId}`);
            let action = button.innerText === 'Suspend' ? 'suspend' : 'activate';
            let actionText = button.innerText === 'Suspend' ? 'suspended' : 'activated';

            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to ${action} this user?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: `Yes, ${action} them!`,
                cancelButtonText: 'No, cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(`/admin/users/${userId}/suspend`).then(response => {
                        Swal.fire('Success', `User ${actionText} successfully`, 'success').then(() => {
                            // Update button and status dynamically as before
                            if (button.innerText === 'Suspend') {
                                button.innerText = 'Activate';
                                button.classList.remove('btn-warning');
                                button.classList.add('btn-success');
                                document.querySelector(`#status-${userId}`).innerText = 'Suspended';
                            } else {
                                button.innerText = 'Suspend';
                                button.classList.remove('btn-success');
                                button.classList.add('btn-warning');
                                document.querySelector(`#status-${userId}`).innerText = 'Active';
                            }
                        });
                    });
                }
            });
        }



        function resetPassword(userId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to reset the password to '12345678'?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, reset it!',
                cancelButtonText: 'No, cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(`/admin/users/${userId}/reset-password`).then(response => {
                        Swal.fire('Success', response.data.success, 'success');
                    });
                }
            });
        }
    </script>

</x-app-layout>
