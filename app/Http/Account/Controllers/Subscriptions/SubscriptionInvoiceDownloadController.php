<?php

namespace SAAS\Http\Account\Controllers\Subscriptions;

use Illuminate\Http\Request;
use SAAS\App\Controllers\Controller;

class SubscriptionInvoiceDownloadController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $invoice
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $invoice)
    {
        return $request->user()->downloadInvoice($invoice, [
            'vendor' => env('COMPANY_NAME', config('app.name')),
            'product' => config('app.name'),
        ]);
    }
}
