<?php
namespace App\Models; // Required namespace

use Illuminate\Database\Eloquent\Model;
// [Key] Extend Authenticatable to use Laravel's Auth::login functionality
use Illuminate\Foundation\Auth\User as Authenticatable;

// Class name must match file name (Manager) and extend Authenticatable (not regular Model)
class Manager extends Authenticatable
{
    // Specify the corresponding database table (must match the managers table name created in phpMyAdmin)
    protected $table = 'managers';
    // Fields allowed for mass assignment (username, password), otherwise user creation will fail
    protected $fillable = ['name', 'password'];
    // If your table doesn't have created_at/updated_at fields, add this line: public $timestamps = false;
}