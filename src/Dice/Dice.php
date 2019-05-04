<?php

namespace Faxity\Dice;

class Dice
{
    /**
     * @var int SIDES The amount of sides the dice has
     */
    const SIDES = 6;

    /**
     * Rolls the dice and gets the value of it
     * @return void.
     */
    public function toss() : int
    {
        $toss = random_int(1, self::SIDES);

        return $toss;
    }
}
