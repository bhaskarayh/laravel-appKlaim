<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClaimTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testIndexReturnsClaims()
    {
        $response = $this->get('/claims');
        $response->assertStatus(200);
        $response->assertSee('Claims Data per LOB');
    }

    public function testSendClaims()
    {
        // Seed data
        Claim::factory()->create(['lob' => 'KUR']);

        $response = $this->post('/send-claims');
        $response->assertStatus(200);
        $response->assertJson(['message' => 'Claims data sent successfully.']);
    }
}
