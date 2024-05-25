<?php

namespace SAAS\App\Breadcrumbs;

use Illuminate\Http\Request;

class Breadcrumbs
{
    /**
     * Request.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Breadcrumbs constructor.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get a custom array of the request's segments.
     *
     * @param int $from
     * @return array
     */
    public function segments($from = 0)
    {
        return collect(array_slice($this->request->segments(), $from))->map(function ($segment) {
            return new Segment($this->request, $segment);
        })->toArray();
    }
}
