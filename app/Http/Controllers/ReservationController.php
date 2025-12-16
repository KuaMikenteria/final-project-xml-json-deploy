<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ReservationController extends Controller
{
    private function getValidMunicipalities(): array
    {
        return [
            'Bulan',
            'Irosin',
            'Legazpi',
            'Matnog',
            'Manila',
            'Quezon City',
            'Makati',
            'Cebu City',
            'Davao City',
            'Baguio',
            'Boracay',
            'Palawan',
            'Bohol',
            'Siargao',
            'Batangas',
            'Laguna',
            'Cavite',
            'Rizal',
            'Bulacan',
            'Iloilo City',
            'Bacolod',
            'Cagayan de Oro',
            'Zamboanga City',
            'Taguig',
            'Pasig',
            'Marikina',
            'Muntinlupa',
            'Las Piñas',
            'Parañaque',
            'Valenzuela',
            'Caloocan',
            'Pasay',
            'Mandaluyong',
            'San Juan',
            'Pateros',
            'Malabon',
            'Navotas',
        ];
    }

    private function getValidCountries(): array
    {
        return [
            'Philippines',
            'United States',
            'United Kingdom',
            'Canada',
            'Australia',
            'Japan',
            'South Korea',
            'Singapore',
            'Malaysia',
            'Thailand',
            'Indonesia',
            'China',
            'India',
            'Germany',
            'France',
            'Spain',
            'Italy',
            'Other',
        ];
    }

    private function getValidResorts(): array
    {
        return [
            'Kuya Boy Beach Resort',
            'Ocean Breeze Beach Resort',
            'Arcadia Beach Resort',
            'Mountain Villa Beach Resort',
            'Calintaan Beach Resort',
        ];
    }

    private function getValidPaymentMethods(): array
    {
        return [
            'Credit Card',
            'GCash',
            'PayPal',
            'Bank Transfer',
            'PayMaya',
        ];
    }

    private function getValidUserRoles(): array
    {
        return [
            'Tourist',
            'Resort Owner',
            'Boat Owner',
            'System Administrator',
        ];
    }
    public function index(Request $request): JsonResponse
    {
        try {
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

            $message = count($reservations) > 0 
                ? 'Reservations retrieved successfully' 
                : 'No reservations found';

            return $this->success($reservations, $message);
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve reservations: ' . $e->getMessage(), 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'phone_number' => [
                    'required',
                    'string',
                    'size:11',
                    'regex:/^09\d{9}$/'
                ],
                'municipality_city' => ['required', Rule::in($this->getValidMunicipalities())],
                'country' => ['required', Rule::in($this->getValidCountries())],
                'user_role' => ['required', Rule::in($this->getValidUserRoles())],
                'resort' => ['required', Rule::in($this->getValidResorts())],
                'check_in_date' => ['required', 'date', 'after_or_equal:today'],
                'check_out_date' => ['nullable', 'date', 'after_or_equal:check_in_date'],
                'number_of_guests' => ['required', 'integer', 'min:1', 'max:100'],
                'payment_method' => ['required', Rule::in($this->getValidPaymentMethods())],
                'password' => ['required', 'string', 'max:255'],
            ], [
                'name.required' => 'The name field is required.',
                'email.required' => 'The email field is required.',
                'email.email' => 'The email must be a valid email address.',
                'phone_number.required' => 'The phone number field is required.',
                'phone_number.size' => 'The phone number must be exactly 11 digits.',
                'phone_number.regex' => 'The phone number must start with 09 and be 11 digits long (Philippine format).',
                'municipality_city.required' => 'The municipality/city field is required.',
                'municipality_city.in' => 'The selected municipality/city is invalid. Please select from the available options.',
                'country.required' => 'The country field is required.',
                'country.in' => 'The selected country is invalid. Please select from the available options.',
                'user_role.required' => 'The user role field is required.',
                'user_role.in' => 'The selected user role is invalid. Please select from: Tourist, Resort Owner, Boat Owner, System Administrator.',
                'resort.required' => 'The resort field is required.',
                'resort.in' => 'The selected resort is invalid. Please select from the available options.',
                'check_in_date.required' => 'The check-in date field is required.',
                'check_in_date.date' => 'The check-in date must be a valid date.',
                'check_in_date.after_or_equal' => 'The check-in date must be today or a future date.',
                'check_out_date.date' => 'The check-out date must be a valid date.',
                'check_out_date.after_or_equal' => 'The check-out date must be the same as or after the check-in date.',
                'number_of_guests.required' => 'The number of guests field is required.',
                'number_of_guests.integer' => 'The number of guests must be a number.',
                'number_of_guests.min' => 'The number of guests must be at least 1.',
                'number_of_guests.max' => 'The number of guests must not exceed 100.',
                'payment_method.required' => 'The payment method field is required.',
                'payment_method.in' => 'The selected payment method is invalid. Please select from: Credit Card, GCash, PayPal, Bank Transfer, PayMaya.',
                'password.required' => 'The password field is required.',
            ]);

            $reservation = Reservation::create($validated);

            return $this->success($reservation, 'Reservation created successfully', 201);
        } catch (ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to create reservation: ' . $e->getMessage(), 500);
        }
    }

    public function show(Reservation $reservation): JsonResponse
    {
        try {
            return $this->success($reservation, 'Reservation retrieved successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to retrieve reservation: ' . $e->getMessage(), 500);
        }
    }

    public function update(Request $request, Reservation $reservation): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'phone_number' => [
                    'required',
                    'string',
                    'size:11',
                    'regex:/^09\d{9}$/'
                ],
                'municipality_city' => ['required', Rule::in($this->getValidMunicipalities())],
                'country' => ['required', Rule::in($this->getValidCountries())],
                'user_role' => ['required', Rule::in($this->getValidUserRoles())],
                'resort' => ['required', Rule::in($this->getValidResorts())],
                'check_in_date' => ['required', 'date'],
                'check_out_date' => ['nullable', 'date', 'after_or_equal:check_in_date'],
                'number_of_guests' => ['required', 'integer', 'min:1', 'max:100'],
                'payment_method' => ['required', Rule::in($this->getValidPaymentMethods())],
                'password' => ['required', 'string', 'max:255'],
            ], [
                'name.required' => 'The name field is required.',
                'email.required' => 'The email field is required.',
                'email.email' => 'The email must be a valid email address.',
                'phone_number.required' => 'The phone number field is required.',
                'phone_number.size' => 'The phone number must be exactly 11 digits.',
                'phone_number.regex' => 'The phone number must start with 09 and be 11 digits long (Philippine format).',
                'municipality_city.required' => 'The municipality/city field is required.',
                'municipality_city.in' => 'The selected municipality/city is invalid. Please select from the available options.',
                'country.required' => 'The country field is required.',
                'country.in' => 'The selected country is invalid. Please select from the available options.',
                'user_role.required' => 'The user role field is required.',
                'user_role.in' => 'The selected user role is invalid. Please select from: Tourist, Resort Owner, Boat Owner, System Administrator.',
                'resort.required' => 'The resort field is required.',
                'resort.in' => 'The selected resort is invalid. Please select from the available options.',
                'check_in_date.required' => 'The check-in date field is required.',
                'check_in_date.date' => 'The check-in date must be a valid date.',
                'check_out_date.date' => 'The check-out date must be a valid date.',
                'check_out_date.after_or_equal' => 'The check-out date must be the same as or after the check-in date.',
                'number_of_guests.required' => 'The number of guests field is required.',
                'number_of_guests.integer' => 'The number of guests must be a number.',
                'number_of_guests.min' => 'The number of guests must be at least 1.',
                'number_of_guests.max' => 'The number of guests must not exceed 100.',
                'payment_method.required' => 'The payment method field is required.',
                'payment_method.in' => 'The selected payment method is invalid. Please select from: Credit Card, GCash, PayPal, Bank Transfer, PayMaya.',
                'password.required' => 'The password field is required.',
            ]);

            $reservation->update($validated);

            return $this->success($reservation->fresh(), 'Reservation updated successfully');
        } catch (ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            return $this->error('Failed to update reservation: ' . $e->getMessage(), 500);
        }
    }

    public function destroy(Reservation $reservation): JsonResponse
    {
        try {
            $reservation->delete();

            return $this->success(null, 'Reservation deleted successfully');
        } catch (\Exception $e) {
            return $this->error('Failed to delete reservation: ' . $e->getMessage(), 500);
        }
    }

    private function success(mixed $data, string $message = '', int $status = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    private function error(string $message, int $status = 400, ?array $errors = null): JsonResponse
    {
        $response = [
            'status' => 'error',
            'message' => $message,
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }
}
