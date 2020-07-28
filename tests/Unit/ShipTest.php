<?php

namespace MKob\Pirates\Tests\Unit;

use MKob\Pirates\PlayerShip;
use MKob\Pirates\Tests\TestCase;

/**
 * Class ShipTest
 * @package MKob\Pirates\Tests\Unit
 */
class ShipTest extends TestCase
{
    /**
     * Test the rolls received when a ship is attacking or defending.
     */
    public function testRolls()
    {
        // Create a PlayerShip instance to test with.
        $ship = new PlayerShip('Test', 15, 5);
        // If we have 3 or more points available when attacking then we get 3 rolls.
        $ship->attack(15);
        $rolls = $ship->getRolls();
        $this->assertTrue(count($rolls) == 3);

        $ship->attack(3);
        $rolls = $ship->getRolls();
        $this->assertTrue(count($rolls) == 3);
        // If we have 2 points available when attacking then we get 2 rolls.
        $ship->attack(2);
        $rolls = $ship->getRolls();
        $this->assertTrue(count($rolls) == 2);
        // If we have 1 point available when attacking then we get 1 roll.
        $ship->attack(1);
        $rolls = $ship->getRolls();
        $this->assertTrue(count($rolls) == 1);
        // If we have 2 or more points available when defending then we get 2 rolls.
        $ship->defend(3);
        $rolls = $ship->getRolls();
        $this->assertTrue(count($rolls) == 2);

        $ship->defend(2);
        $rolls = $ship->getRolls();
        $this->assertTrue(count($rolls) == 2);
        // If we have 1 point available when defending then we get 1 roll.
        $ship->defend(1);
        $rolls = $ship->getRolls();
        $this->assertTrue(count($rolls) == 1);
    }

    /**
     * Test the damage taken by a ship which is under attack.
     */
    public function testDamageTaken()
    {
        // Stop the application output from being printed to the console during testing.
        $this->setOutputCallback(function() {});
        // Create a PlayerShip instance to test with.
        $ship = new PlayerShip('Test', 15, 5);
        // Get the ship's starting health.
        $starting_health = $ship->getHealth();
        // Determine how much damamge we want the ship to take.
        $damage = 5;
        // Damage the ship.
        $ship->damageTaken($damage);
        // The ship should have 5 less health points than it started with.
        $this->assertTrue($ship->getHealth() == $starting_health - $damage);
        // Over-damage the ship.
        $damage = $ship->getHealth() + 1;

        $ship->damageTaken($damage);
        // The ship should not go into negative damage and be on 0 health points.
        $this->assertTrue($ship->getHealth() === 0);
    }

    /**
     * Test if the ship is sunk.
     */
    public function testIsSunk()
    {
        // Stop the application output from being printed to the console during testing.
        $this->setOutputCallback(function() {});
        // Create a PlayerShip instance to test with.
        $ship = new PlayerShip('Test', 15, 5);
        // The newly created ship should not yet be sunk.
        $this->assertFalse($ship->isSunk());
        // Damage the ship enough to sink it.
        $damage = $ship->getHealth() + 1;

        $ship->damageTaken($damage);
        // The ship should be sunk.
        $this->assertTrue($ship->isSunk());
    }
}
