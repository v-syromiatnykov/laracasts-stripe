<?php

namespace App;

use Stripe\Customer;

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

        $this->user->activate($customer->id);
    }
}
