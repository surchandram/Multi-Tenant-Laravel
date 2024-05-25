<?php

namespace SAAS\Http\WebApps\Controllers;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;
use SAAS\Domain\WebApps\Filters\AppFilters;

class AppFiltersController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return response()->json([
            'data' => AppFilters::mappings(),
        ]);
    }
}
