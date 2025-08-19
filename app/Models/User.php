<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'credit',
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
        'credit' => 'decimal:2',
    ];
    
    /**
     * Get the roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Check if the user has a specific role.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    /**
     * Check if the user is a super admin.
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->hasRole('super_admin');
    }

    /**
     * Check if user is admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole('employee') || $this->hasRole('super_admin');
    }

    /**
     * Get the products bought by this user.
     */
    public function boughtProducts()
    {
        return $this->hasMany(BoughtProduct::class);
    }

    /**
     * Add credit to user account.
     *
     * @param float $amount
     * @return bool
     */
    public function addCredit($amount)
    {
        if ($amount > 0) {
            $this->credit += $amount;
            return $this->save();
        }
        return false;
    }

    /**
     * Deduct credit from user account.
     *
     * @param float $amount
     * @return bool
     */
    public function deductCredit($amount)
    {
        if ($amount > 0 && $this->credit >= $amount) {
            $this->credit -= $amount;
            return $this->save();
        }
        return false;
    }

    /**
     * Check if user has sufficient credit.
     *
     * @param float $amount
     * @return bool
     */
    public function hasSufficientCredit($amount)
    {
        return $this->credit >= $amount;
    }

    /**
     * Check if the user has any of the given roles.
     *
     * @param array $roles
     * @return bool
     */
    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    /**
     * Check if the user has a specific permission.
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermission($permission)
    {
        return $this->roles()->whereHas('permissions', function ($query) use ($permission) {
            $query->where('name', $permission);
        })->exists();
    }
}
