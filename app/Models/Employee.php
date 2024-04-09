<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Employee extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'type',
        'last_operation',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAuthPasswordAttribute()
    {
        return $this->password;
    }
}
