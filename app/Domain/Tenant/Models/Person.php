<?php

namespace SAAS\Domain\Tenant\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Miracuthbert\Multitenancy\Traits\ForTenants;
use SAAS\App\Support\Traits\Eloquent\CanOwnAddress;

class Person extends Model
{
    use CanOwnAddress;
    use ForTenants;
    use HasFactory;
    use Notifiable;
    use Notifiable;
    use SoftDeletes;

    protected $table = 'persons';

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];
}
