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

    protected function makeSubscribedUser($overrides = [])
    {
        $user = factory('App\User')->create($overrides);

        $user->subscription()
            ->create($this->getPlan(), $this->getStripeToken());

        return $user;
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

    /** @test */
    public function it_subscribes_a_user_using_a_coupon_code()
    {
        $user = factory('App\User')->create();

        $user->subscription()
            ->usingCoupon('TEST-COUPON')
            ->create($this->getPlan(), $this->getStripeToken());

        $customer = $user->subscription()->retrieveStripeCustomer();

        try {
            $couponAppliedToStripe = $customer->invoices()->data[0]->discount->coupon->id;

            $this->assertEquals('TEST-COUPON', $couponAppliedToStripe);
        } catch (\Exception $e) {
            $this->fail('Expected a coupon to be applied to the Stripe customer, but did not find one');
        }
    }
}
