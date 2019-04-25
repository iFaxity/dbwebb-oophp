<?php

namespace Faxity\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Dice100 test class.
 */
class Dice100Test extends TestCase
{
    public function testGameOver()
    {
        $game = new Dice100();
        $gameOver = false;

        // run game for a while until gameover is true
        for ($i = 0; $i < 1000; $i++) {
            // End round right after toss so we save score
            $game->toss();
            $game->endTurn();

            if ($game->gameOver()) {
                $gameOver = true;
                break;
            }
        }

        $this->assertTrue($gameOver);
    }

    public function testRender()
    {
        $game = new Dice100();

        // No one tossed yet, nothing to render
        $this->assertEquals("", $game->render());

        // after toss there will be something to render
        $game->toss();

        $this->assertNotEquals("", $game->render());
    }

    public function testGetters()
    {
        $game = new Dice100();

        $this->assertInstanceOf(Player::class, $game->player());
        $this->assertInstanceOf(CPU::class, $game->cpu());
    }
}
