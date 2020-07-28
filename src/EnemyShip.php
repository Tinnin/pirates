<?php

namespace MKob\Pirates;

/**
 * Class EnemyShip
 * The enemy's instance of a ship.
 * @package MKob\Pirates
 */
class EnemyShip extends Ship
{
    /**
     * Gives a shout out to the console to identify the ship.
     * @return mixed|void A shout out to the console.
     */
    public function shipIdentifier()
    {
        echo "I am the Enemy Ship\n";
    }
}
