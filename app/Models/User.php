<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'active',
        'email',
        'password',
        'name',
        'short_name',
        'birth_date',
        'avatar',
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
        'password' => 'hashed',
    ];

    
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    
    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'admin_id');
    }

    
    public function employees(): HasMany
    {
        return $this->hasMany(User::class, 'created_by', 'id');
    }

    
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    
    /** Возращает кол-во пользователей, которые были созданы текущим пользователем */
    public function employeesCount(): int
    {
        return $this->employees()->count();
    }

}
