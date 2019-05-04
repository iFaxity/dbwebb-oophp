<?php

namespace Faxity\Dice;

/**
 * Game handler for dice 100 game
 */
class Game extends Histogram
{
    /**
     * @var int $cpu The CPU player aka the server
     * @var int $player The user player
     */
    private $cpu;
    private $player;

    /**
     * Instantiates a new dice game handler.
     */
    public function __construct()
    {
        $this->cpu = new CPU();
        $this->player = new Player();
    }

    /**
     * Tosses the dice for the player.
     * @return void.
     */
    public function toss() : void
    {
        $this->serie = [];
        $this->cpu->clearSerie();
        $this->player->toss();

        // Player got a 0 when tossing dice, end turn
        if ($this->player->turnScore() == 0) {
            $this->endTurn(false);
        }
    }

    /**
     * Ends the turn for the player and lets the cpu roll
     * @return void.
     */
    public function endTurn($clearSerie = true) : void
    {
        if ($clearSerie) {
            $this->player->clearSerie();
        }

        $this->player->endTurn();
        $this->cpu->toss(); // automatically ends turn
    }

    /**
     * Getter for the player
     * @return Player.
     */
    public function player() : Player
    {
        return $this->player;
    }

    /**
     * Getter for the CPU
     * @return CPU.
     */
    public function cpu() : CPU
    {
        return $this->cpu;
    }

    /**
     * Renders what happened most recently between cpu and player.
     * @return string.
     */
    public function render() : string
    {
        $res = "";
        $playerRenders = [];

        if ($this->player->shouldRender()) {
            $playerRenders[] = $this->player->render();
        }

        if ($this->cpu->shouldRender()) {
            $playerRenders[] = $this->cpu->render();
        }

        // render histogram
        if (!empty($playerRenders)) {
            // Set data to the histogram before rendering
            $this->injectData($this->player, $this->cpu);

            // Render the player tosses and stats
            $res .= "<div class=\"players\">";
            foreach ($playerRenders as $str) {
                $res .= $str;
            }
            $res .= "</div>";

            // Render the histogram
            $res .= "<div class=\"histogram\">";
            $res .= "<h2>Histogram för rundan</h2>";
            $res .= $this->renderHistogram();
            $res .= "</div>";
        }

        return $res;
    }

    /**
     * Checks if a player has won yet
     * @return bool.
     */
    public function gameOver() : bool
    {
        return $this->cpu->totalScore() >= 100 || $this->player->totalScore() >= 100;
    }
}
