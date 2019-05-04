<?php

namespace Faxity\Dice;

/**
 * Class to represent a player in the dice game 100
 */
class Player implements HistogramInterface
{
    use HistogramTrait;

    /**
     * @var int $score The current secured score of the user
     * @var array $dice The dices this player has
     * @var int $turnScore The score the player has not yet secured
     * @var int $tosses All toss values of every player
     * @var int DICE_COUNT The amount of dices the player holds
     */
    private $score = 0;
    protected $dice = [];
    protected $turnScore = 0;
    protected static $tosses = [];
    const DICE_COUNT = 6;

    /**
     * Instiansiates a new Player class
     */
    public function __construct()
    {
        for ($i = 0; $i < self::DICE_COUNT; $i++) {
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
     * Checks if we should render the player
     * @return bool.
     */
    public function shouldRender() : bool
    {
        return !empty($this->serie);
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
     * Tosses the dice and adds to the turnScore
     * If we tossed a 1 the turnScore is reset
     * @return void.
     */
    public function toss() : void
    {
        // If we start a new round, our tosses need to be reset
        if ($this->turnScore == 0) {
            $this->clearSerie();
        }

        $reset = false;

        foreach ($this->dice as $die) {
            $toss = $die->toss();
            $toss == 1 && $reset = true;

            // tosses are used for CPU to get all tosses
            self::$tosses[] = $toss;
            $this->serie[] = $toss;
            $this->turnScore += $toss;
        }

        // Reset score if player rolled a 1
        if ($reset) {
            $this->turnScore = 0;
        }
    }

    /**
     * Renders html to represent the last toss(es)
     * @return string.
     */
    public function render() : string
    {
        $res = "";

        for ($offset = 0; $offset < count($this->serie); $offset += Dice::SIDES) {
            $turn = 1 + ($offset / Dice::SIDES);
            $values = array_slice($this->serie, $offset, Dice::SIDES);

            $res .= $this->renderTurn($turn, $values);
        }

        // Enclose the dice rolls with info about the round
        if (!empty($res)) {
            $name = $this instanceof CPU ? "Servern" : "Du";

            $res = <<<EOT
            <div class="player">
                <h2>{$name} slog:</h2>
                <p>Poäng denna runda: {$this->turnScore}</p>
                {$res}
            </div>
EOT;
        }

        return $res;
    }

    private function renderTurn(int $turn, array $values) : string
    {
        $res = array_reduce($values, function ($acc, $value) use ($turn) {
            return $acc . "<svg class=\"dice\"><use xlink:href=\"#icon-dice-{$value}\" /></svg>";
        }, "");

        return "<div class=\"dice-turn\"><p>Kast #{$turn}:</p>{$res}</div>";
    }
}
