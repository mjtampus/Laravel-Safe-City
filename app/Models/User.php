<?php

namespace App\Models;

use App\Models\AccidentReport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;

class User extends Model implements Authenticatable
{
    use HasFactory, Notifiable, AuthenticatableTrait;

    protected $fillable = [
        'name',
        'age',
        'lastname',
        'gender',
        'birthdate',
        'phone',
        'email',
        'password',
        'role',
        'chosen_marker',
        'profile_image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function accidentReports()
    {
        return $this->hasMany(AccidentReport::class);
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
    public function isRestricted()
    {
        // Add your logic to determine if the user is restricted
        // For example, check if the user has a restricted role or attribute
        return $this->role === 'restricted';
    }
    public function confirmedReports()
    {
        return $this->hasMany(AccidentReport::class)->where('location_status', true);
    }
    public function matchesSearch($search)
    {
        return (
            empty($search) ||
            strpos(strtolower($this->name), strtolower($search)) !== false ||
            strpos(strtolower($this->email), strtolower($search)) !== false ||
            strpos(strtolower($this->phone), strtolower($search)) !== false
        );
    }
}