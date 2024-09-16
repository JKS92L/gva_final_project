<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'phone',
        'profile_image',
        'password',
        'remember_token',
        'activation_code',
        'forgotten_password_code',
        'forgotten_password_time',
        'remember_code',
        'created_on',
        'last_login',
        'active',
        'user_status',
        'leave_status',
        'leave_start',
        'leave_end',
        'salary',
        'phone_number',
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

    /**
     * Get the URL for the user's profile image.
     *
     * @return string
     */
    public function adminlte_image()
    {
        return $this->profile_image
            ? asset('storage/profile_images/' . $this->profile_image)
            : asset('images/gva_logo/grand_view_logo.png'); // Default logo
    }

    /**
     * Get the URL for the user's profile page.
     *
     * @return string
     */
    public function adminlte_profile_url()
    {
        return 'admin/profile';
    }

    // Optionally, you can uncomment this if you want to display the user's role in the profile description
    // public function adminlte_desc()
    // {
    //     return $this->roles->pluck('name')->join(', '); // Assuming you want to display all roles
    // }
}
