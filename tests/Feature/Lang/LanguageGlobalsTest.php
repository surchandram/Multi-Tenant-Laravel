<?php

namespace Tests\Feature\Lang;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class LanguageGlobalsTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_it_contains_a_list_of_available_languages()
    {
        $response = $this->get('/');

        $response->assertInertia(function (AssertableInertia $page) {
            $page->where('languages.0.value', 'en')
                ->where('languages.0.label', 'English');
        });
    }

    public function test_it_contains_the_current_selected_language()
    {
        app()->setLocale('de');

        $response = $this->get('/');

        $response->assertInertia(function (AssertableInertia $page) {
            $page->where('language', 'de');
        });
    }

    public function test_it_contains_all_translations()
    {
        $response = $this->get('/');

        $response->assertInertia(function (AssertableInertia $page) {
            $data = Arr::get($page->toArray(), 'props.translations');

            $this->assertArrayHasKey('auth.failed', $data);
        });
    }
}
