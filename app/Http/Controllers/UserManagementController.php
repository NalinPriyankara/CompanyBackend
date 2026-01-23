<?php

namespace App\Http\Controllers;

use App\Repositories\All\UserManagement\UserManagementInterface;
use App\Http\Requests\UserManagementRequest;
use App\Models\UserManagement;
use Illuminate\Http\JsonResponse;

class UserManagementController extends Controller
{
    private UserManagementInterface $userRepo;

    public function __construct(UserManagementInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index(): JsonResponse
    {
        $users = $this->userRepo->all();
        return response()->json($users);
    }

    public function store(UserManagementRequest $request): JsonResponse
    {
        $data = $request->validated();
        // Remove manual bcrypt—model cast handles it

        $user = $this->userRepo->create($data);
        return response()->json($user, 201);
    }

    public function show(int $id): JsonResponse
    {
        $user = $this->userRepo->find($id);
        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    public function update(UserManagementRequest $request, int $id): JsonResponse
    {
        $user = $this->userRepo->find($id);
        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $data = $request->validated();

        // Remove manual bcrypt if present—model cast handles it
        //unset($data['password']); // Avoid re-hashing if not provided (cast will skip if null)
        if (!isset($data['password']) || empty($data['password'])) {
            unset($data['password']);
        }

        $updated = $this->userRepo->update($id, $data);
        if (! $updated) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Refresh user to get updated data
        $user->refresh();

        return response()->json([
            'message' => 'Updated successfully',
            'user' => $user
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        $user = $this->userRepo->find($id);
        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $deleted = $this->userRepo->delete($id);
        if (! $deleted) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['message' => 'User deleted']);
    }
}
