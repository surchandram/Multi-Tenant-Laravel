<?php

namespace SAAS\Domain\Admin\Actions;

class StopUserImpersonationAction
{
    public static function execute()
    {
        session()->forget('impersonate');
    }
}
