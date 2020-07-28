<?php

namespace MKob\Pirates;

/**
 * Class Ship
 * The ship instance used for all ships that go into battle.
 * @package MKob\Pirates
 */
abstract class Ship
{
    /**
     * @var string The name of the ship.
     */
    public $name;
    /**
     * @var int The ship's attack points.
     */
    public $attack;
    /**
     * @var int The ship's defence points.
     */
    public $defence;
    /**
     * @var int The ship's hit points.
     */
    private $health;
    /**
     * @var array The ship's rolls for each turn are stored here.
     */
    private $rolls = [];

    /**
     * Ship constructor.
     * @param $name string The name of the ship.
     * @param $attack int The ship's attack points.
     * @param $defence int The ship's defence points.
     */
    public function __construct($name, $attack, $defence)
    {
        // Set the ship's base properties.
        $this->name = $name;
        $this->attack = $attack;
        $this->defence = $defence;
        // Health is set to 100 for all ships for now. Could change this to be ship specific...
        $this->health = 100;
    }

    /**
     * Determines the ships attack in the skirmish with dice rolls.
     * @param $points_available int The number of temporary attack points available for an attack.
     */
    public function attack($points_available)
    {
        // Roll the dice with the available attack points.
        $this->rollDice($points_available, true);
    }

    /**
     * Determines the ships defence in the skirmish with dice rolls.
     * @param $points_available int The number of temporary defence points available for a defence.
     */
    public function defend($points_available)
    {
        // Roll the dice with the available defence points.
        $this->rollDice($points_available);
    }

    /**
     * Roll the dice.
     * @param $points_available int The points available for a dice roll.
     * @param bool $attacking Determine's if the ship is attacking or defending for this roll.
     */
    private function rollDice($points_available, $attacking = false)
    {
        // Clear the ship's previous rolls.
        $this->rolls = [];

        // Calculate the number of allowed rolls.
        // Following "Risk" rules, if the ship is attacking then it can have a maximum of 3 rolls but must have at
        // least that number of points available. If less than 3 points then the number of rolls is determined
        // by the number of points.
        // If defending then the ship can have only a maximum of 2 rolls.
        if ($attacking && $points_available >= 3) {
            $number_of_allowed_rolls = 3;
        } elseif ($points_available >= 2) {
            $number_of_allowed_rolls = 2;
        } else {
            $number_of_allowed_rolls = 1;
        }
        // Create a new dice instance to roll with.
        $dice = new Dice();
        // Roll the the dice the number of allowed times and store the results to be checked later.
        foreach (range(1, $number_of_allowed_rolls) as $i) {
            $this->rolls[] = $dice->roll();
        }
        // Sort the rolls from highest to lowest to ease comparison later.
        rsort($this->rolls);
    }

    /**
     * Get the ship's rolls.
     * @return array Return the rolls for the ship.
     */
    public function getRolls()
    {
        return $this->rolls;
    }

    /**
     * Get the ship's health.
     * @return int Return the health.
     */
    public function getHealth()
    {
        return $this->health > 0 ? $this->health : 0;
    }

    /**
     * Take damage.
     * @param $damage int The amount of points the ship will lose from its health property.
     */
    public function damageTaken($damage)
    {
        // Reduce the ships health by the amount of damage received.
        $this->health -= $damage;
        // Announce how much damage the ship has taken.
        echo $this->name . " has taken " . $damage . " points of damage.\n";
        // Provide a health update of the ship to the console.
        $this->healthUpdate();
    }

    /**
     * Give an update of the ship's current health to the console.
     */
    public function healthUpdate()
    {
        echo $this->name . " has " . ($this->getHealth()) . " HP remaining.\n";
    }

    /**
     * Determines if the ship is sunk.
     * @return bool Is the ships health greater than zero.
     */
    public function isSunk()
    {
        return $this->health <= 0;
    }

    /**
     * Call out for the ship.
     * @return mixed
     */
    abstract public function shipIdentifier();
}
