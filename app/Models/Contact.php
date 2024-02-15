<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['first_name', 'last_name', 'email'];

    // Add any additional relationships or methods as needed
}