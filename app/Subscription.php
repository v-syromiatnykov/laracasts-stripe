<?php

namespace App;

use Stripe\Customer;
use Stripe\Subscription as StripeSubscription;

class Subscription
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create(Plan $plan, $token)
    {
        $customer = Customer::create([
            'email' => $this->user->email,
            'source' => $token,
            'plan' => $plan->name,
        ]);

        $subscriptionId = $customer->subscriptions->data[0]->id;

        $this->user->activate($customer->id, $subscriptionId);
    }

    public function retrieve()
    {
        return StripeSubscription::retrieve($this->user->stripe_subscription);
    }
}
