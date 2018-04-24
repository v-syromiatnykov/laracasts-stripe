<?php

namespace App\Http\Controllers;

use Stripe\Charge;
use Stripe\Customer;

class PurchasesController extends Controller
{
    public function store()
    {
        $customer = Customer::create([
            'email' => request('stripeEmail'),
            'source' => request('stripeToken')
        ]);

        $charge = Charge::create([
            'customer' => $customer->id,
            'amount' => 2500,
            'currency' => 'usd'
        ]);

        var_dump($customer, $charge);

        return 'All done';
    }
}
