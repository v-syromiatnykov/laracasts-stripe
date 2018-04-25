<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function activate($customerId)
    {
        return $this->update([
            'stripe_id' => $customerId,
            'stripe_active' => true
        ]);
    }

    public function isSubscribed()
    {
        return !! $this->stripe_active;
    }
}
