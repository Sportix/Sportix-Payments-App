<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\RandomOrderTransactionNumberGenerator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RandomOrderNumberGeneratorTest extends TestCase
{
    // Must be 24 characters long
    // Can only contain uppercase letters and numbers
    // Cannot contain ambiguous characters
    // All order confirmation numbers must be unique
    //
    // ABCDEFGHJKLMNPQRSTUVWXYZ
    // 23456789
    /** @test */
    function must_be_24_characters_long()
    {
        $generator = new RandomOrderTransactionNumberGenerator;
        $confirmationNumber = $generator->generate();
        $this->assertEquals(24, strlen($confirmationNumber));
    }
    /** @test */
    function can_only_contain_uppercase_letters_and_numbers()
    {
        $generator = new RandomOrderTransactionNumberGenerator;
        $confirmationNumber = $generator->generate();
        $this->assertRegExp('/^[A-Z0-9]+$/', $confirmationNumber);
    }
    /** @test */
    function cannot_contain_ambiguous_characters()
    {
        $generator = new RandomOrderTransactionNumberGenerator;
        $confirmationNumber = $generator->generate();
        $this->assertFalse(strpos($confirmationNumber, '1'));
        $this->assertFalse(strpos($confirmationNumber, 'I'));
        $this->assertFalse(strpos($confirmationNumber, '0'));
        $this->assertFalse(strpos($confirmationNumber, 'O'));
    }
    /** @test */
    function confirmation_numbers_must_be_unique()
    {
        $generator = new RandomOrderTransactionNumberGenerator;
        $confirmationNumbers = array_map(function ($i) use ($generator) {
            return $generator->generate();
        }, range(1, 100));
        $this->assertCount(100, array_unique($confirmationNumbers));
    }
}
