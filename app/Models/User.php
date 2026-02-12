<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Core\imageCategory;
use App\Models\EmployeeDepartment;
use App\Models\EmployeeDetails;
use App\Models\DayOffReplace;
use App\Models\Leads;


class User extends Authenticatable
{
    use  HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'first_name',
        'email',
        'gender',
        'address',
        'country_id',
        'default_address_id',
        'country_code',
        'phone',
        'avatar',
        'status',
        'is_seen',
        'auth_id_tiwilo',
        'dob',
        'role_id',
        'nationality',
        'emirate_of_residence'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
   
}
