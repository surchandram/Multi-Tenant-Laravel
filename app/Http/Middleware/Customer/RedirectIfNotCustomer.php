<?php

namespace SAAS\Http\Middleware\Customer;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SAAS\Domain\Tenant\Actions\VerifyUserIsCustomerAction;

class RedirectIfNotCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // check if current user is a valid customer for company
        $verified = VerifyUserIsCustomerAction::execute($request->user(), $request->tenant());

        if (! $verified) {
            return abort(Response::HTTP_NOT_FOUND);
        }

        return $next($request);
    }
}
