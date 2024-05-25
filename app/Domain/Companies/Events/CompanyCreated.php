<?php

namespace SAAS\Domain\Companies\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use SAAS\Domain\Companies\Models\Company;

class CompanyCreated
{
    use Dispatchable, SerializesModels;

    /**
     * Company instance.
     *
     * @var \SAAS\Domain\Companies\Models\Company
     */
    public $company;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }
}
