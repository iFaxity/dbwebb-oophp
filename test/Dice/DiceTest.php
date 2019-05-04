<?php

namespace Faxity\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Dice test class.
 */
class DiceTest extends TestCase
{
    public function testToss()
    {
        $dice = new Dice();

        // just roll 10 times and check the number is between 1 and 6
        for ($i = 0; $i < 10; $i++) {
            $toss = $dice->toss();
            $this->assertTrue($toss >= 1 && $toss <= 6);
        }
    }
}
