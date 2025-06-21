<?php

namespace App\Policies;

use App\Models\User;

class CategoryPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function delete(User $user){
        if ($user->role == "manager") {
            return Response::allow();
        } else {
            return Response::deny("Only manager can do delete");
        }
    }
}
