<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\InteractsWithStripe;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase, InteractsWithStripe;

    /** @test */
    public function it_subscribes_a_user()
    {
        $user = $this->makeSubscribedUser(['stripe_active' => false]);

        $user = $user->fresh();

        $this->assertTrue($user->isSubscribed());

        try {
            $user->subscription()->retrieveStripeSubscription();
        } catch (\Exception $e) {
            $this->fail('No stripe subs');
        }
    }
    
    /** @test */
    public function it_cancels_a_user_subscription()
    {
        $user = $this->makeSubscribedUser();

        $user->subscription()->cancel();

        $stripeSubscription = $user->subscription()->retrieveStripeSubscription();

        $this->assertNotNull($stripeSubscription->canceled_at);

        $this->assertFalse($user->isSubscribed());

        $this->assertNotNull($user->subscription_end_at);
    }

    protected function makeSubscribedUser($overrides = [])
    {
        $user = factory('App\User')->create($overrides);

        $user->subscription()->create($this->getPlan(), $this->getStripeToken());

        return $user;
    }
}
