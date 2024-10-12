<?php

use App\Models\User;

class UserController extends Controller
{
    public function assignRole()
    {
        $user = User::find(1); // Find the user by ID

        // Assign the 'admin' role to the user
        $user->assignRole('admin');

        return "Role assigned!";
    }
}
