<?php

namespace Faxity\Dice100;

class Player
{
    /**
     * @var int $die The dies this player has
     * @var int $score The current secured score of the user
     * @var int $roundScore The score the player has not yet secured
     * @var int DIE_COUNT The amount of dies the player holds
     */
    private $die;
    private $score;
    private $roundScore;
    const DIE_COUNT = 6;

    /**
     * Instantiates a new Player object.
     */
    public function __construct()
    {
        $this->score = 0;
        $this->roundScore = 0;
        $this->die = [];

        for ($i = 0; $i < self::DIE_COUNT; $i++) {
            $this->die[] = new Dice();
        }
    }


    /**
     * Gets the players current score
     *
     * @return int.
     */
    public function score()
    {
        return $this->score;
    }


    /**
     * Gets the players current round score
     *
     * @return int.
     */
    public function roundScore()
    {
        return $this->roundScore;
    }

    /**
     * Gets the players current total score
     *
     * @return int.
     */
    public function totalScore()
    {
        return $this->score + $this->roundScore;
    }


    /**
     * Tosses the dice and returns the dice values
     *
     * @return void.
     */
    public function toss()
    {
        $reset = false;

        foreach ($this->die as $dice) {
            $toss = $dice->toss();
            $this->roundScore += $toss;

            // Reset round score
            if ($toss == 1) {
                $reset = true;
            }
        }

        if ($reset) {
            $this->roundScore = 0;
        }
    }

    /**
     * Moves all the points earned this turn into secure score
     *
     * @return void.
     */
    public function endTurn()
    {
        $this->score += $this->roundScore;
        $this->roundScore = 0;
    }

    /**
     * Creates an HTML representation of the last toss.
     *
     * @return string.
     */
    public function render()
    {
        $res = array_reduce($this->die, function ($acc, $dice) {
            return $acc .= $dice->render();
        }, "");

        return "<div class=\"die\">{$res}</div>";
    }

    /**
     * Checks if we have tossed the dice yet, only used to check first
     *
     * @return boolean.
     */
    public function tossed()
    {
        // Just checks if we have tossed yet, just for beginning check.
        return $this->die[0]->lastToss() != null;
    }

    /**
     * Clears the dice from the last toss
     *
     * @return void.
     */
    public function clearToss()
    {
        foreach ($this->die as $dice) {
            $dice->clearToss();
        }
    }
}
