<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SecurityRolesController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    $user = $request->user();

    if (!$user) {
        return response()->json(null, 204);
    }

    // fetch role row from security_roles by role name (the user_profiles.role column)
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

    return response()->json([
        'id' => $user->id ?? null,
        'email' => $user->email ?? null,
        'telephone' => $user->telephone ?? null,
        'image' => $user->image ?? null,
        'role' => $user->role ?? null,
        'role_id' => $roleRow->id ?? null,
        'sections' => $sections,
        'areas' => $areas,
        'status' => $user->status ?? null,
        'first_name' => $user->first_name ?? ($user->firstName ?? null),
        'last_name' => $user->last_name ?? ($user->lastName ?? null),
    ]);
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Storage file serving routes
Route::get('/storage/{path}', [StorageController::class, 'inline'])->where('path', '.*');

Route::resource("user-managements", UserManagementController::class);

Route::apiResource('security-roles', SecurityRolesController::class);
Route::apiResource('projects', ProjectController::class);
Route::apiResource('feedbacks', FeedbackController::class);
Route::apiResource('logo', LogoController::class);
Route::apiResource('contacts', ContactController::class);
