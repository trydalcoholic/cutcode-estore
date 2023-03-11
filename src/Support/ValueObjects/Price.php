<?php

declare(strict_types=1);

namespace Support\ValueObjects;

use InvalidArgumentException;
use Stringable;
use Support\Traits\Makeable;

final class Price implements Stringable
{
    use Makeable;

    private array $currencies = [
        'RUB' => '₽',
    ];

    public function __construct(
        private readonly int $value,
        private readonly string $currency = 'RUB',
        private readonly int $precession = 100,
    ) {
        if ($value < 0) {
            throw new InvalidArgumentException('Price must be than zero.');
        }

        if (! isset($this->currencies[$this->currency])) {
            throw new InvalidArgumentException('Currency not allowed.');
        }
    }

    public function getRaw(): int
    {
        return $this->value;
    }

    public function getValue(): float|int
    {
        return $this->value / $this->precession;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getSymbol(): string
    {
        return $this->currencies[$this->currency];
    }

    public function __toString(): string
    {
        return number_format($this->getValue(), 0, ',', ' ').' '.$this->getSymbol();
    }
}
