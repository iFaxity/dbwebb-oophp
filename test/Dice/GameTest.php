<?php

namespace Faxity\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Game test class.
 */
class GameTest extends TestCase
{
    public function testGameOver()
    {
        $game = new Game();
        $gameOver = false;

        // run game for a while until gameover is true,
        // Or 20 rounds
        for ($i = 0; $i < 20; $i++) {
            // End round right after toss so we save score
            $game->toss();
            $game->endTurn();

            if ($game->gameOver()) {
                $gameOver = true;
                break;
            }
        }

        // Check if $gameOver matches the result
        $playerWon = $game->player()->totalScore() >= 100;
        $cpuWon = $game->cpu()->totalScore() >= 100;

        $this->assertEquals($gameOver, $playerWon || $cpuWon);
    }

    public function testRender()
    {
        $game = new Game();

        // No one tossed yet, nothing to render
        $this->assertEquals("", $game->render());

        // after toss there will be something to render
        $game->toss();

        $this->assertNotEquals("", $game->render());
    }

    public function testGetters()
    {
        $game = new Game();

        $this->assertInstanceOf(Player::class, $game->player());
        $this->assertInstanceOf(CPU::class, $game->cpu());
    }
}
