<?php

namespace App\Repositories\All\Auth;

use App\Models\UserManagement;

interface AuthInterface
{
    public function login(array $credentials): ?array;

    public function logout(UserManagement $user): bool;
}
