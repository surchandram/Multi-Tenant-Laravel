<?php

namespace Tests\Feature\Lang;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LanguageTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_sets_the_language_correctly()
    {
        $response = $this->post('/language', [
            'language' => $language = 'de',
        ]);

        $response
            ->assertStatus(302)
            ->assertSessionHas('language', $language);
    }

    public function test_sets_the_default_language_if_chosen_language_is_invalid()
    {
        $response = $this->post('/language', [
            'language' => 'jp',
        ]);

        $response
            ->assertStatus(302)
            ->assertSessionHas('language', config('app.locale'));
    }
}
