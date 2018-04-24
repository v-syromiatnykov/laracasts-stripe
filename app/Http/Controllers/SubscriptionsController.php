<?php

namespace App\Http\Controllers;

use App\Plan;
use Stripe\Charge;
use Stripe\Customer;

class SubscriptionsController extends Controller
{
    public function store()
    {
        $plan = Plan::findOrFail(request('plan'));

        $customer = Customer::create([
            'email' => request('stripeEmail'),
            'source' => request('stripeToken'),
            'plan' => $plan->name,
        ]);

        return 'All done';
    }
}
