<?php

namespace MKob\Pirates;

/**
 * Class PlayerShip
 * The player's instace of a ship.
 * @package MKob\Pirates
 */
class PlayerShip extends Ship
{
    /**
     * Gives a shout out to the console to identify the ship.
     * @return mixed|void A shout out to the console.
     */
    public function shipIdentifier()
    {
        echo "I am the Player Ship\n";
    }
}
