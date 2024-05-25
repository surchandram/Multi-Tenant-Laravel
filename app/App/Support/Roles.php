<?php

namespace SAAS\App\Support;

class Roles
{
    public static $roleWhenCreatingCompany = 'company-admin';

    public static $roleWhenJoiningCompany = 'company-member';

    /**
     * A map of company roles.
     *
     * @return array
     */
    public static function teamRolesMap()
    {
        return [
            static::$roleWhenJoiningCompany => 'Member',
        ];
    }
}
