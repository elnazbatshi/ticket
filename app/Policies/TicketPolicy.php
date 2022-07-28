<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        dd($user->roles()->get()->toArray());
    }
}
