<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Volunteer extends Authenticatable
{
    protected $table = 'volunteers'; // Corresponds to volunteers table
    protected $fillable = ['name', 'password'];
}