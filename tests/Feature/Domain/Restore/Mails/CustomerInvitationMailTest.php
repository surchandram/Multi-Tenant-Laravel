<?php

namespace Tests\Feature\Domain\Restore\Mails;

use Tests\TestCase;

class CustomerInvitationMailTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
