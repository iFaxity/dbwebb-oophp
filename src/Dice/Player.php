<?php

namespace Faxity\Dice;

/**
 * Class to represent a player in the dice game 100
 */
class Player
{
    /**
     * @var int $score The current secured score of the user
     * @var array $dice The dices this player has
     * @var int $turnScore The score the player has not yet secured
     * @var array $serie The dice rolls that has happened
     * @var int DIE_COUNT The amount of dices the player holds
     */
    private $score = 0;
    protected $dice = [];
    protected $turnScore = 0;
    protected static $serie = [];
    const DIE_COUNT = 6;

    /**
     * Instiansiates a new Player class
     */
    public function __construct()
    {
        for ($i = 0; $i < self::DIE_COUNT; $i++) {
            $this->dice[] = new Dice();
        }
    }

    /**
     * Gets the players current score
     * @return int.
     */
    public function score() : int
    {
        return $this->score;
    }

    /**
     * Gets the score the player earned so far this turn
     * @return int.
     */
    public function turnScore() : int
    {
        return $this->turnScore;
    }

    /**
     * Gets the sum of turnScore and score
     * @return int.
     */
    public function totalScore() : int
    {
        return $this->score + $this->turnScore;
    }

    /**
     * Tosses the dice and adds to the turnScore
     * If we tossed a 1 the turnScore is reset
     * @return void.
     */
    public function toss() : void
    {
        // If we start a new round, our tosses need to be reset
        if ($this->turnScore == 0) {
            $this->clearToss();
        }

        $reset = false;

        foreach ($this->dice as $die) {
            $toss = $die->toss();
            $toss == 1 && $reset = true;

            self::$serie[] = $toss;
            $this->turnScore += $toss;
        }

        // Reset score if player rolled a 1
        if ($reset) {
            $this->turnScore = 0;
        }
    }

    /**
     * Clears the tosses made this turn
     * @return void.
     */
    public function clearToss() : void
    {
        foreach ($this->dice as $die) {
            $die->endTurn();
        }
    }

    /**
     * Secures the score earned this turn
     * @return void.
     */
    public function endTurn() : void
    {
        $this->score += $this->turnScore;
        $this->turnScore = 0;
    }

    /**
     * Renders html to represent the last toss(es)
     * @return string.
     */
    public function render() : string
    {
        $turn = 0;

        // Sort dice renders into a 2 dimensional array
        $rendered = array_reduce($this->dice, function ($acc, $die) {
            $res = $die->render();

            for ($i = 0; $i < count($res); $i++) {
                if (!array_key_exists($i, $acc)) {
                    $acc[$i] = "";
                }

                $acc[$i] .= $res[$i];
            }

            return $acc;
        }, []);


        return array_reduce($rendered, function ($acc, $str) use (&$turn) {
            $turn++;

            return $acc . "<div class=\"dice-turn\"><p>Kast #{$turn}:</p>{$str}</div>";
        }, "");
    }
}
