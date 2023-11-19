<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PublicEventListTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_that_all_site_visitors_can_see_event_lists(): void
    {

        $response = $this->get('/api/events');

        $response->assertStatus(200);
    }
}
