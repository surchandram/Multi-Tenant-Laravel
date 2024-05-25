<?php

namespace SAAS\App\Payments\Exceptions;

use Exception;

class PaymentFailedException extends Exception
{
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        //
    }
}
