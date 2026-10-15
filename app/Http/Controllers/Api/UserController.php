<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::query()->latest()->paginate(20));
    }

    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:student,teacher,admin'],
            'status' => ['sometimes', 'in:active,pending,rejected'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);

        return (new UserResource($user))
            ->response()
            ->setStatusCode(201)
            ->header('Location', route('api.users.show', $user));
    }

    public function update(Request $request, User $user): UserResource
    {
        $data = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'username' => ['sometimes', 'nullable', 'string', 'max:255', 'unique:users,username,'.$user->id],
            'email' => ['sometimes', 'required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'password' => ['sometimes', 'required', 'string', 'min:8'],
            'role' => ['sometimes', 'required', 'in:student,teacher,admin'],
            'status' => ['sometimes', 'required', 'in:active,pending,rejected'],
        ]);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return new UserResource($user->refresh());
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus.',
        ]);
    }
}
