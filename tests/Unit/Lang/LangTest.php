<?php

namespace Tests\Unit\Lang;

use SAAS\Lang\Lang;
use Tests\TestCase;

class LangTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_can_get_an_associated_language_label()
    {
        $this->assertEquals(Lang::DE->label(), 'Deutsch');
    }
}
