<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'username',
        'address',
    ];

    public $timestamps = false;
}
