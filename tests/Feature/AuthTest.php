<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function testAcessWithNoToken(): void
    {
        # Trying to access protected routes
        $response = $this->get('/api/collaborators/list');
        $response->assertStatus(401);
    }
}
