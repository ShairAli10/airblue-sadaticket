<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{

    use Notifiable, HasRoles;
    protected $guard = 'admin';
    protected $table = "admins";

    protected $fillable = [
        'first_name', 'last_name', 'type','email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token','otp_code',
    ];

    public static $status = [
        1 => 'Active',
        0 => 'Inactive'
    ];

    public static $statusCast = [];

    static function initializeStaticProperties() {
        self::$statusCast = array_flip(self::$status);
    }

}
Admin::initializeStaticProperties();
