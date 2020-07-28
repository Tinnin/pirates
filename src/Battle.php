<?php

namespace MKob\Pirates;

/**
 * Class Battle
 * The outcome of the player's rolls are processed here.
 * @package MKob\Pirates
 */
class Battle
{
    /**
     * @var bool determines if the battle is still active.
     */
    public $active;

    /**
     * Battle constructor.
     */
    public function __construct()
    {
        // Activate the battle.
        $this->active = true;
    }

    /**
     * @param Ship $attacker the attacking ship
     * @param Ship $defender the defending ship
     */
    public function engage($attacker, $defender)
    {
        // Determines if the ships are still engaged in the skirmish.
        $engaged = true;
        // We'll use the attack and defence points to determine the outcome. But we don't want them to be changed,
        // so we'll create some temporary variables to keep track of them.
        $attack_points = $attacker->attack;
        $defence_points = $defender->defence;
        // Engage the ships.
        while ($engaged) {
            // Players roll their dice.
            $attacker->attack($attack_points);
            $defender->defend($defence_points);
            // Compare the rolls
            // We compare the highest rolls for each player. We can only compare the same number of rolls for
            // each so we need to determine the minimum number of rolls between players.
            // The rolls are pre-ordered from highest to lowest.
            for ($i = 0; $i < min(count($attacker->getRolls()), count($defender->getRolls())); $i++) {
                // If the attacker's roll is higher than the defender's then the attacker wins and the defender loses
                // one defence point from the temporary points store.
                // Otherwise, the attacker loses and attack point.
                if ($attacker->getRolls()[$i] > $defender->getRolls()[$i]) {
                    $defence_points--;
                    // If the defender's temporary defence points are at zero, the attacker's remaining temporary
                    // attack points are used to give damage to the defender.
                    if ($defence_points == 0) {
                        // Check for "Lucky Shot!".
                        // A 10% chance of a lucky shot, increases the attacker's closing attack by three-fold.
                        // This is based on the number of temporary attack points left after the rolling comparison.
                        if (rand(1, 10) === 1) {
                            echo $attacker->name . " got in a lucky shot!\n";
                            $attack_points = $attack_points * 3;
                        }
                        // Inflict damage on the defender.
                        $defender->damageTaken($attack_points);
                        // Disengage the ships.
                        $engaged = false;
                        break;
                    }
                } else {
                    // If the roll comparison favours the defender, either with a higher roll for the defender or
                    // a draw, then decrease the attacker's temporary attack points.
                    $attack_points--;
                    // If the atttacker's temporary attack points reach zero, the attack was defended against and
                    // no damamge was done.
                    if ($attack_points == 0) {
                        echo "The attack was successfully defended.\n";
                        // Give the defender's health update. Their health will be the same as before the skirmish.
                        $defender->healthUpdate();
                        // Disengage the ships.
                        $engaged = false;
                        break;
                    }
                }
            }
        }
    }
}
