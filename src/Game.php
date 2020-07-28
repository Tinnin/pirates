<?php

namespace MKob\Pirates;

/**
 * Class Game
 * This is where the game will run.
 * @package MKob\Pirates
 */
class Game
{
    /**
     * Plays the game until it is over.
     */
    public function play()
    {
        // Ship selection:
        echo "Choose your ship:\n";
        echo "Ship A: Attack 15. Defence 5.\n";
        echo "Ship B: Attack 5. Defence 15.\n";
        echo "Select A or B\n";

        $selection_made = false;
        // Have the player choose either Ship A or B.
        while ($selection_made === false) {
            $selection = trim(fgets(STDIN));
            if (!in_array($selection, ['a', 'A', 'b', 'B'])) {
                echo "Select A or B\n";
            } else {
                $selection_made = true;
                if (in_array($selection, ['a', 'A'])) {
                    $player = new PlayerShip("The Player", 15, 5);
                    $enemy = new EnemyShip("The Enemy",5, 15);
                } else {
                    $player = new PlayerShip("The Player",5, 15);
                    $enemy = new EnemyShip("The Enemy",15, 5);
                }
            }
            // Polymorphism for the sake of it.
            // Each ship has its own unique shout out.
            $player->shipIdentifier();
            $enemy->shipIdentifier();
        }
        // Create a battle instance for the two ships to do battle in.
        $battle = new Battle();
        // Keep taking turns until the battle is over.
        while ($battle->active) {
            echo "\nEngage with the enemy! (Press enter)\n";
            if (fgets(STDIN)) {
                // The player takes the first turn.
                $this->turn($battle, $player, $enemy);
                if ($battle->active) {
                    // If the enemy is still alive then they take their turn immediately.
                    $this->turn($battle, $enemy, $player);
                }
            }
        }
    }

    /**
     * Players take turns to attack one another's ships.
     * @param Battle $battle the battle instance
     * @param Ship $attacker the attacking ship
     * @param Ship $defender the defending ship
     */
    public function turn($battle, $attacker, $defender)
    {
        // Check if the attack landed.
        // There is a 25% chance of the attack missing, resulting in zero damage to the defending ship.
        if (rand(1, 4) === 1) {
            echo "The attack missed.\n";
            // Remind the player of the defender's health.
            $defender->healthUpdate();
        } else {
            // If the attack didn't miss, engage the ships to determine the outcome of the skirmish.
            $battle->engage($attacker, $defender);
            // If the defender is sunk, the game is over. Declare the victor.
            if ($defender->isSunk()) {
                echo "The battle is over. " . $attacker->name . " has won!\n";
                // End the battle.
                $battle->active = false;
            }
        }
    }
}
