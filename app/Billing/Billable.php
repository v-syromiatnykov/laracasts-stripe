<?php

namespace App\Billing;

use App\Subscription;
use Carbon\Carbon;

trait Billable
{
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

    public function deactivate($endDate = null)
    {
        $endDate = $endDate ?: Carbon::now();

        return $this->update([
            'stripe_active' => false,
            'subscription_end_at' => $endDate
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

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
