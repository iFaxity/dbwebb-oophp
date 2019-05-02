<?php

namespace Faxity\Dice100;

class Dice100
{
    /**
     * @var int $cpu The CPU player aka the server
     * @var int $player The user player
     */
    private $cpu;
    private $player;

    /**
     * Instantiates a new 100 Dice game handler.
     */
    public function __construct()
    {
        $this->cpu = new CPU();
        $this->player = new Player();
    }

    /**
     * Tosses the dice for the player.
     *
     * @return void.
     */
    public function toss()
    {
        // Clear cpu toss before we toss
        $this->cpu->clearToss();
        $this->player->toss();

        // Player got a 0 when tossing dice
        if ($this->player->roundScore() == 0) {
            $this->endTurn();
        }
    }

    /**
     * Ends the turn for the player and lets the cpu roll
     *
     * @return void.
     */
    public function endTurn()
    {
        $this->player->endTurn();
        $this->cpu->toss();
        $this->cpu->endTurn();
    }

    /**
     * Getter for the player
     *
     * @return Player.
     */
    public function player()
    {
        return $this->player;
    }

    /**
     * Getter for the CPU
     *
     * @return CPU.
     */
    public function cpu()
    {
        return $this->cpu;
    }

    /**
     * Renders what happened most recently between cpu and player.
     *
     * @return string.
     */
    public function render()
    {
        $res = "";

        if ($this->player->tossed()) {
            $res .= "<h1>Du slog: </h1>";
            $res .= "Osäkrade poäng: {$this->player->roundScore()}";
            $res .= $this->player->render();
        }

        if ($this->cpu->tossed()) {
            $res .= "<h1>Servern slog: </h1>";
            $res .= $this->cpu->render();
        }

        return $res;
    }

    /**
     * Checks if a player has won yet
     *
     * @return bool.
     */
    public function gameOver()
    {
        return $this->cpu->totalScore() >= 100 || $this->player->totalScore() >= 100;
    }
}
