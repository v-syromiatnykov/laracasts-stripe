<?php

namespace App;

use Carbon\Carbon;
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

    public static function byStripeId($stripeId)
    {
        return static::where('stripe_id', $stripeId)->firstOrFail();
    }

    public function setStripeSubscription($id)
    {
        $this->stripe_subscription = $id;
    }
    
    public function activate($customerId, $subscriptionId)
    {
        return $this->update([
            'stripe_id' => $customerId,
            'stripe_active' => true,
            'stripe_subscription' => $subscriptionId,
            'subscription_end_at' => 0
        ]);
    }

    public function deactivate()
    {
        return $this->update([
            'stripe_active' => false,
            'subscription_end_at' => Carbon::now()
        ]);
    }

    public function subscription()
    {
        return new Subscription($this);
    }

    public function isSubscribed()
    {
        return !! $this->stripe_active;
    }
}
