<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    // model structure
    protected $fillable = [
        'username',
        'address',
        'identity',
    ];

    public $timestamps = false;
}
