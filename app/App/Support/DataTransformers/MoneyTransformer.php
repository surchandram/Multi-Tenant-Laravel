<?php

namespace SAAS\App\Support\DataTransformers;

use SAAS\App\Support\Money;
use Spatie\LaravelData\Support\DataProperty;
use Spatie\LaravelData\Transformers\Transformer;

class MoneyTransformer implements Transformer
{
    public function transform(DataProperty $property, mixed $value): string
    {
        return Money::from($value)->formatted();
    }
}
