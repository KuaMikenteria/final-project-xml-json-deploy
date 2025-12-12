<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReservationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search = trim((string) $request->query('search', ''));

        $reservations = Reservation::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($nested) use ($search) {
                    $nested
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone_number', 'like', "%{$search}%")
                        ->orWhere('resort', 'like', "%{$search}%")
                        ->orWhere('municipality_city', 'like', "%{$search}%")
                        ->orWhere('country', 'like', "%{$search}%")
                        ->orWhere('user_role', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('created_at')
            ->get();

        return $this->success($reservations);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone_number' => ['required', 'string', 'regex:/^09\d{9}$/'],
            'municipality_city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'user_role' => ['required', Rule::in([
                'Tourist',
                'Resort Owner',
                'Boat Owner',
                'System Administrator'
            ])],
            'resort' => ['required', Rule::in([
                'Kuya Boy Beach Resort',
                'Ocean Breeze Beach Resort',
                'Arcadia Beach Resort',
                'Mountain Villa Beach Resort',
                'Calintaan Beach Resort'
            ])],
            'check_in_date' => ['required', 'date', 'after_or_equal:today'],
            'check_out_date' => ['nullable', 'date', 'after_or_equal:check_in_date'],
            'number_of_guests' => ['required', 'integer', 'min:1', 'max:100'],
            'payment_method' => ['required', Rule::in([
                'Credit Card',
                'GCash',
                'PayPal',
                'Bank Transfer',
                'PayMaya'
            ])],
            'password' => ['required', 'string', 'max:255'],
        ]);

        $reservation = Reservation::create($validated);

        return $this->success($reservation, 'Reservation created successfully', 201);
    }

    public function show(Reservation $reservation): JsonResponse
    {
        return $this->success($reservation);
    }

    public function update(Request $request, Reservation $reservation): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone_number' => ['required', 'string', 'regex:/^09\d{9}$/'],
            'municipality_city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'user_role' => ['required', Rule::in([
                'Tourist',
                'Resort Owner',
                'Boat Owner',
                'System Administrator'
            ])],
            'resort' => ['required', Rule::in([
                'Kuya Boy Beach Resort',
                'Ocean Breeze Beach Resort',
                'Arcadia Beach Resort',
                'Mountain Villa Beach Resort',
                'Calintaan Beach Resort'
            ])],
            'check_in_date' => ['required', 'date'],
            'check_out_date' => ['nullable', 'date', 'after_or_equal:check_in_date'],
            'number_of_guests' => ['required', 'integer', 'min:1', 'max:100'],
            'payment_method' => ['required', Rule::in([
                'Credit Card',
                'GCash',
                'PayPal',
                'Bank Transfer',
                'PayMaya'
            ])],
            'password' => ['required', 'string', 'max:255'],
        ]);

        $reservation->update($validated);

        return $this->success($reservation->fresh(), 'Reservation updated successfully');
    }

    public function destroy(Reservation $reservation): JsonResponse
    {
        $reservation->delete();

        return $this->success(null, 'Reservation deleted successfully');
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
