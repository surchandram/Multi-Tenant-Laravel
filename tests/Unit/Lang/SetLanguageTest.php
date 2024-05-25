<?php

namespace Tests\Unit\Lang;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SAAS\Http\Middleware\SetLanguage;
use Tests\TestCase;

class SetLanguageTest extends TestCase
{
    public function test_it_sets_the_chosen_locale()
    {
        $request = new Request();
        $request->setLaravelSession(app('session')->driver());

        session()->put('language', 'de');

        (new SetLanguage())->handle($request, function ($request) {
            $this->assertEquals(app()->getLocale(), 'de');

            return new Response();
        });
    }
}
