<?php

namespace App\Repositories\All\Auth;

use App\Models\UserManagement;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthRepository extends BaseRepository implements AuthInterface
{
    public function __construct(UserManagement $model)
    {
        parent::__construct($model);
    }

    public function login(array $credentials): ?array
    {
        $user = $this->model->where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // if ($user->status !== 'active') {
        //     return [
        //         'error' => true,
        //         'message' => 'Your account is not active',
        //         'status' => 403
        //     ];
        // }

        $token = $user->createToken('auth-token')->plainTextToken;

        // fetch role row from security_roles by role name (the user_managements.role column)
        $roleRow = DB::table('security_roles')->where('role', $user->role)->first();

        $sections = [];
        $areas = [];

        if ($roleRow) {
            if (!empty($roleRow->sections)) {
                $sections = array_values(array_filter(explode(';', $roleRow->sections)));
            }
            if (!empty($roleRow->areas)) {
                $areas = array_values(array_filter(explode(';', $roleRow->areas)));
            }
        }

        return [
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'telephone' => $user->telephone,
                'role' => $user->role,
                'role_id' => $roleRow->id ?? null,
                'sections' => $sections,
                'areas' => $areas,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
            ],
            'token' => $token
        ];
    }

    public function logout(UserManagement $user): bool
    {
        $user->tokens()->delete();
        return true;
    }
}