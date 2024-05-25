<?php

namespace Tests\Feature\Domain\Restore\Jobs\Project;

use Tests\TestCase;

class SendProjectApprovedNotificationsJobTest extends TestCase
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
