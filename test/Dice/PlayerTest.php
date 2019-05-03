<?php

namespace Faxity\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Player test class.
 */
class PlayerTest extends TestCase
{
    public function testToss()
    {
        $player = new Player();
        $turnScore = 0;

        while ($turnScore == 0) {
            $player->toss();
            $turnScore = $player->turnScore();
        }

        // Roundscore should be same, score should be 0
        // Because we haven't ended the turn yet
        $this->assertEquals($player->turnScore(), $turnScore);
        $this->assertEquals(0, $player->score());
    }

    public function testEndTurn()
    {
        $player = new Player();
        $turnScore = 0;

        // Run until we win a toss
        while ($turnScore == 0) {
            $player->toss();
            $turnScore = $player->turnScore();
        }

        // When turn is ended score is added by turnScore,
        // Check if past turnScore is equal to player score
        $player->endTurn();

        $this->assertEquals($turnScore, $player->score());
        $this->assertEquals(0, $player->turnScore());
    }
}
