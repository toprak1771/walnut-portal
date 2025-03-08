<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminUser extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    
    use HasFactory,SoftDeletes;

    protected $table = 'admin_users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}
