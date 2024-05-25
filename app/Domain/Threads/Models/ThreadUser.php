<?php

namespace SAAS\Domain\Threads\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Miracuthbert\Multitenancy\Traits\ForTenants;

class ThreadUser extends Pivot
{
    use ForTenants;
}
