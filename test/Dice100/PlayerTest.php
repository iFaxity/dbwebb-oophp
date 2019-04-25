<?php

namespace Faxity\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Player test class.
 */
class PlayerTest extends TestCase
{
    public function testToss()
    {
        $player = new Player();
        $roundScore = $player->roundScore();

        while ($roundScore == 0) {
            $player->toss();
            $roundScore = $player->roundScore();
        }

        // Roundscore should be same, score should be 0
        // Because we haven't ended the turn yet
        $this->assertEquals($player->roundScore(), $roundScore);
        $this->assertEquals(0, $player->score());
    }

    public function testEndTurn()
    {
        $player = new Player();
        $roundScore = $player->roundScore();

        while ($roundScore == 0) {
            $player->toss();
            $roundScore = $player->roundScore();
        }

        // When turn is ended score is added by roundScore,
        // Check if past roundScore is equal to player score
        $player->endTurn();

        $this->assertEquals($roundScore, $player->score());
        $this->assertEquals(0, $player->roundScore());
    }

    public function testTossed()
    {
        $player = new Player();

        $this->assertFalse($player->tossed());

        while ($player->roundScore() == 0) {
            $player->toss();
        }

        $this->assertTrue($player->tossed());

        // Clears the tosses, should be false
        $player->clearToss();
        $this->assertFalse($player->tossed());
    }
}
