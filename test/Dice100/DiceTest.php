<?php

namespace Faxity\Dice100;

use PHPUnit\Framework\TestCase;

/**
 * Dice test class.
 */
class DiceTest extends TestCase
{
    /**
     * Just assert something is true.
     */
    public function testToss()
    {
        $dice = new Dice();

        // just roll 10 times and check the number is between 1 and 6
        for ($i = 0; $i < 10; $i++) {
            $toss = $dice->toss();
            $this->assertTrue($toss >= 1 && $toss <= 6);
        }
    }

    public function testLastToss()
    {
        $dice = new Dice();
        $res = $dice->lastToss();

        $this->assertEquals($res, null);

        $num = $dice->toss();
        $res = $dice->lastToss();

        $this->assertEquals($num, $res);
    }

    public function testClearToss()
    {
        $dice = new Dice();
        $dice->toss();

        // First check that toss is not null
        $this->assertNotEquals(null, $dice->lastToss());

        $dice->clearToss();

        // After clearing toss should be null
        $this->assertEquals(null, $dice->lastToss());
    }
}
