<?php

namespace Tests\Feature\Domain\Users\Mails;

use Tests\TestCase;

class UserInvitationReminderMailTest extends TestCase
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
