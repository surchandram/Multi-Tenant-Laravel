<?php

namespace SAAS\App\Support;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money as BaseMoney;
use NumberFormatter;

class Money
{
    /**
     * Money instance.
     *
     * @var BaseMoney
     */
    protected $money;

    /**
     * Money constructor.
     *
     * @param $value
     */
    public function __construct($value)
    {
        $this->money = new BaseMoney($value, new Currency(config('saas.currency')));
    }

    /**
     * Get new money instance from value.
     *
     * @param  int  $value
     * @return \SAAS\App\Support\Money
     */
    public static function from(int $value): self
    {
        return new self($value);
    }

    /**
     * Return the objects amount.
     *
     * @return string
     */
    public function amount()
    {
        return $this->money->getAmount();
    }

    /**
     * Get formatted money.
     *
     * @return string
     */
    public function formatted()
    {
        $formatter = new IntlMoneyFormatter(
            new NumberFormatter('en_US', NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );

        return $formatter->format($this->money);
    }

    /**
     * Add an instance of money.
     *
     * @param  Money  $money
     * @return $this
     */
    public function add(Money $money)
    {
        $this->money = $this->money->add($money->instance());

        return $this;
    }

    /**
     * Get an instance of money.
     *
     * @return BaseMoney
     */
    public function instance()
    {
        return $this->money;
    }
}
