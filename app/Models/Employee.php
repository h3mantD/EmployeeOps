<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;

final class Employee extends User
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'last_operation',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAuthPasswordAttribute()
    {
        return $this->password;
    }

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
