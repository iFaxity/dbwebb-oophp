<?php

namespace Faxity\Dice100;

class Dice
{
    /**
     * @var int $lastToss Last roll value
     */
    private $lastToss;
    const SIDES = 6;

    /**
     * Instansiates a new Dice object.
     */
    public function __construct()
    {
        $this->lastToss = null;
    }

    /**
     * Rolls the dice and gets the value of it
     *
     * @return void.
     */
    public function toss()
    {
        return $this->lastToss = random_int(1, self::SIDES);
    }

    /**
     * Renders html to represent the last toss
     *
     * @return string.
     */
    public function render()
    {
        return "<svg class=\"dice\"><use xlink:href=\"#icon-dice-{$this->lastToss}\" /></svg>";
    }

    /**
     * Rolls the dice and gets the value of it
     *
     * @return int.
     */
    public function lastToss()
    {
        return $this->lastToss;
    }

    /**
     * Clears the last toss value.
     *
     * @return void.
     */
    public function clearToss()
    {
        $this->lastToss = null;
    }
}
