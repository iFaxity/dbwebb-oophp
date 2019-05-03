<?php

namespace Faxity\Dice;

use PHPUnit\Framework\TestCase;

/**
 * CPU test class.
 */
class CPUTest extends TestCase
{
    public function testToss()
    {
        $cpu = new CPU();

        // Run a couple of times so we can test it fully
        for ($i = 0; $i < 100; $i++) {
            $score = $cpu->score();

            $cpu->toss();

            // CPU should only stop tossing if score was 0 or if it wants to end itself
            $this->assertTrue(($cpu->score() - $score) == 0 || $cpu->shouldEndTurn());
        }
    }
}
