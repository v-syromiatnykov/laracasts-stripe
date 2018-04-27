<?php

namespace Tests\Feature;

use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BillableTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_deterines_if_a_users_subcription_is_active()
    {
        $user = factory('App\User')->create([
            'stripe_active' => true,
            'subscription_end_at' => null
        ]);

        $this->assertTrue($user->isActive());

        $user->update([
            'stripe_active' => false,
            'subscription_end_at' => Carbon::now()->addDays(2)
        ]);

        $this->assertTrue($user->isActive());

        $user->update([
            'subscription_end_at' => Carbon::now()->subDays(2)
        ]);

        $this->assertFalse($user->isActive());
    }
    
    /** @test */
    public function it_determines_if_a_users_subcription_is_on_a_grace_period()
    {
        $user = factory('App\User')->create([
            'subscription_end_at' => null
        ]);

        $this->assertFalse($user->isOnGracePeriod());

        $user->subscription_end_at = Carbon::now()->addDays(2);

        $this->assertTrue($user->isOnGracePeriod());

        $user->subscription_end_at = Carbon::now()->subDays(2);

        $this->assertFalse($user->isOnGracePeriod());

    }
}
