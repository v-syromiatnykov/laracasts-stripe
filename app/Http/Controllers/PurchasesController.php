<?php

namespace App\Http\Controllers;

use App\Product;
use Stripe\Charge;
use Stripe\Customer;

class PurchasesController extends Controller
{
    public function store()
    {
        $product = Product::findOrFail(request('product'));

        $customer = Customer::create([
            'email' => request('stripeEmail'),
            'source' => request('stripeToken')
        ]);

        $charge = Charge::create([
            'customer' => $customer->id,
            'amount' => $product->price,
            'currency' => 'usd'
        ]);

        var_dump($customer, $charge);

        return 'All done';
    }
}
