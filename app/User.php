<?php

namespace App;

use App\Billing\Billable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, Billable;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
