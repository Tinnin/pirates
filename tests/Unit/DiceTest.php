<?php

namespace MKob\Pirates\Tests\Unit;

use MKob\Pirates\Dice;
use MKob\Pirates\Tests\TestCase;

/**
 * Class DiceTest
 * @package MKob\Pirates\Tests\Unit
 */
class DiceTest extends TestCase
{
    /**
     * Test the dice's roll function.
     */
    public function testRoll()
    {
        // Create an instance of the dice to roll with.
        $dice = new Dice();
        // Roll the dice.
        $roll = $dice->roll();
        // The dice should roll a number between 1 and 6 inclusive.
        $this->assertTrue(in_array($roll, range(1, 6)));
    }
}
