<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = trim((string) $request->query('search', ''));

        $users = User::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($nested) use ($search) {
                    $nested
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%")
                        ->orWhere('contact_number', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('created_at')
            ->get(['id', 'name', 'email', 'role', 'contact_number', 'created_at', 'updated_at']);

        return $this->success($users);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', Rule::in(['Tourist', 'Resort Owner', 'Administrator'])],
            'contact_number' => ['nullable', 'string', 'max:50'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        return $this->success($user->only(['id', 'name', 'email', 'role', 'contact_number', 'created_at', 'updated_at']), 'User created', 201);
    }

    public function show(User $user): JsonResponse
    {
        return $this->success($user->only(['id', 'name', 'email', 'role', 'contact_number', 'created_at', 'updated_at']));
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', Rule::in(['Tourist', 'Resort Owner', 'Administrator'])],
            'contact_number' => ['nullable', 'string', 'max:50'],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return $this->success($user->fresh()->only(['id', 'name', 'email', 'role', 'contact_number', 'created_at', 'updated_at']), 'User updated');
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return $this->success(null, 'User deleted');
    }

    private function success(mixed $data, string $message = '', int $status = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $status);
    }
}


