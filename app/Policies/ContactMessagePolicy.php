<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ContactMessage;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactMessagePolicy
{
    use HandlesAuthorization;

public function viewAny(User $user)
{
    return $user->isAdmin(); // ✅ Use method, not $user->is_admin
}

public function update(User $user, ContactMessage $message)
{
    return $user->isAdmin();
}

public function delete(User $user, ContactMessage $message)
{
    return $user->isAdmin();
}

}