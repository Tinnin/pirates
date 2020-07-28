<?php

namespace MKob\Pirates;

/**
 * Class Dice
 * An instance of the dice to be rolled.
 * @package MKob\Pirates
 */
class Dice
{
    /**
     * Rolls the dice.
     * @return int a random number between 1 and 6.
     */
    public function roll()
    {
        return rand(1, 6);
    }
}
