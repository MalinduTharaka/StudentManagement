<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10); // Pagination
        return view('admin.users.index', compact('users'));
    }

    public function changeRole(Request $request, User $user)
    {
        $user->role = $request->role;
        $user->save();

        return response()->json(['success' => 'Role updated successfully!']);
    }

    public function suspendUser(User $user)
    {
        // Toggle the 'suspended' status
        $user->suspended = !$user->suspended;
        $user->save(); // Ensure this line saves the updated status to the database

        return response()->json(['success' => 'User status updated!']);
    }


    public function resetPassword(User $user)
    {
        $user->password = bcrypt('12345678');
        $user->save();

        return response()->json(['success' => 'Password reset to 12345678']);
    }


}
