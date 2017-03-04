<?php
namespace Tests\Unit;

use Tests\TestCase;

class UtilityHelper extends TestCase {

    /** @test */
    public function it_converts_currency_to_cents_if_dollar_sign()
    {
        $this->assertEquals(6500, convertCurrencyToCents('$65'));
        $this->assertEquals(6600, convertCurrencyToCents('$66.00'));
        $this->assertEquals(6750, convertCurrencyToCents('$67.50'));
        $this->assertEquals(2500, convertCurrencyToCents('25.00'));
        $this->assertEquals(3300, convertCurrencyToCents('33'));
        $this->assertEquals(1150, convertCurrencyToCents('$11.5'));
        $this->assertEquals(0, convertCurrencyToCents('$0.00'));
        $this->assertEquals(0, convertCurrencyToCents('0'));
        $this->assertEquals(0, convertCurrencyToCents('0.00'));
    }

    /** @test */
    public function it_displays_currency_from_cents()
    {
        $this->assertEquals('$65.00', currency(6500));
        $this->assertEquals('$15.30', currency(1530));
        $this->assertEquals('$0.00', currency(0));
    }
}
