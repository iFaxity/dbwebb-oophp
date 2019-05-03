<?php

namespace Faxity\Dice;

class Dice
{
    /**
     * @var array $tosses The tosses made by the user this round
     * @var int SIDES The amount of sides the dice has
     */
    private $tosses = [];
    const SIDES = 6;


    /**
     * Gets the tossed values made this turn
     * @return array.
     */
    public function tosses() : array
    {
        return $this->tosses;
    }

    /**
     * Rolls the dice and gets the value of it
     * @return void.
     */
    public function toss() : int
    {
        $toss = random_int(1, self::SIDES);
        $this->tosses[] = $toss;

        return $toss;
    }

    /**
     * Clears all the tosses for this turn
     * @return void.
     */
    public function endTurn() : void
    {
        $this->tosses = [];
    }

    /**
     * Renders html to represent the last round of tosses,
     * returns an array with every toss as a string
     * @return array.
     */
    public function render() : array
    {
        return array_map(function ($value) {
            return $this->renderToss($value);
        }, $this->tosses);
    }

    /**
     * Internal function for rendering a dice toss
     * @return string.
     */
    private function renderToss($toss) : string
    {
        return "<svg class=\"dice\"><use xlink:href=\"#icon-dice-{$toss}\" /></svg>";
    }
}
