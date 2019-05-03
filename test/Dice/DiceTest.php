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

    public function testTosses()
    {
        $dice = new Dice();
        $tosses = $dice->tosses();

        // no tosses yet
        $this->assertTrue(empty($tosses));

        $res = [
            $dice->toss(),
            $dice->toss(),
            $dice->toss(),
        ];

        // should match the tossed values
        $tosses = $dice->tosses();

        for ($i = 0; $i < count($tosses); $i++) {
            $this->assertEquals($tosses[$i], $res[$i]);
        }
    }

    public function testEndTurn()
    {
        $dice = new Dice();
        $dice->toss();

        // First check that toss has one element
        $len = count($dice->tosses());

        $this->assertEquals(1, $len);

        $dice->endTurn();

        // After ending turn tosses should be empty
        $len = count($dice->tosses());

        $this->assertEquals(0, $len);
    }
}
