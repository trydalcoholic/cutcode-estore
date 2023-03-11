<?php

declare(strict_types=1);

namespace Support\ValueObjects;

use InvalidArgumentException;
use Tests\TestCase;

final class PriceTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function it_all(): void
    {
        $price = Price::make(10000);

        $this->assertInstanceOf(Price::class, $price);
        $this->assertEquals(100, $price->getValue());
        $this->assertEquals(10000, $price->getRaw());
        $this->assertEquals('RUB', $price->getCurrency());
        $this->assertEquals('₽', $price->getSymbol());
        $this->assertEquals('100 ₽', $price);

        $this->expectException(InvalidArgumentException::class);

        Price::make(-10000);
        Price::make(10000, 'USD');
    }
}
