<?php

namespace SAAS\App\Pages\Components\Contracts;

interface PageComponentInterface
{
    public static function define(array $data);

    public function key();

    public function value();

    public function type();

    public function typeClass();
}
