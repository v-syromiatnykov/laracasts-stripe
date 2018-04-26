<?php

namespace Tests\Feature;

use App\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\InteractsWithStripe;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase, InteractsWithStripe;

    /** @test */
    public function it_subscribes_a_user()
    {
        $user = factory('App\User')->create(['stripe_active' => false]);

        $subscription = new Subscription($user);

        $subscription->create($this->getPlan(), $this->getStripeToken());

        $user = $user->fresh();

        $this->assertTrue($user->isSubscribed());

        try {
            $user->subscription()->retrieve();
        } catch (\Exception $e) {
            $this->fail('No stripe subs');
        }
    }
}
