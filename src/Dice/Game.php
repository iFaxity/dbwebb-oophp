<?php

namespace Faxity\Dice;

/**
 * Game handler for dice 100 game
 */
class Game
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
        $this->cpu->clearToss();
        $this->player->toss();

        // Player got a 0 when tossing dice, end turn
        if ($this->player->turnScore() == 0) {
            $this->endTurn();
        }
    }

    /**
     * Ends the turn for the player and lets the cpu roll
     * @return void.
     */
    public function endTurn() : void
    {
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
        $player = $this->player->render();
        $cpu =    $this->cpu->render();

        if (!empty($player)) {
            $res .= "<h2>Du slog:</h2>";
            $res .= "<p>Poäng denna runda: {$this->player->turnScore()}</p>";
            $res .= $player;
        }

        if (!empty($cpu)) {
            $res .= "<h2>Servern slog:</h2>";
            $res .= $cpu;
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
