<?php

namespace Tests\Feature;

use App\Http\Controllers\WebhooksController;
use Tests\TestCase;

class WebhooksControllerTest extends TestCase
{
    /** @test */
    public function it_converts_a_stripe_event_name_to_a_method_name()
    {
        $name = (new WebhooksController)->eventToMethod('customer.subscription.deleted');

        $this->assertEquals('whenCustomerSubscriptionDeleted', $name);
    }
}
