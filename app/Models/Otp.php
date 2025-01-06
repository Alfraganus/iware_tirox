<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;
    CONST TYPE_REGISTRATION = 'Registration';
    CONST TYPE_RECOVERY = 'RESTORE_PASSWORD';
    protected $fillable = [
        'email', 'type', 'code', 'lifetime', 'attempts','payload'
    ];
}
