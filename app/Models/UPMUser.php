<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UPMUser extends Authenticatable
{
    protected $table = 'upm_users'; // Corresponds to upm_users table
    protected $fillable = ['name', 'password'];
}