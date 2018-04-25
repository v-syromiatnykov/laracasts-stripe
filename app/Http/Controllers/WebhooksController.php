<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class WebhooksController extends Controller
{
    public function handle()
    {
        $payload = request()->all();

        if ($payload['type'] == 'customer.subscription.deleted') {
            $user = User::where('stripe_id', $payload['data']['object']['customer'])->firstOrFail();
            $user->deactivate();

            return response('Webhook Received');
        }

//        return $payload;
    }
}
