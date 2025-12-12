<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'municipality_city',
        'country',
        'user_role',
        'resort',
        'check_in_date',
        'check_out_date',
        'number_of_guests',
        'payment_method',
        'password',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'number_of_guests' => 'integer',
    ];
}
