<?php

namespace Faxity\Dice;

use PHPUnit\Framework\TestCase;

// Include the helper class
include __DIR__ . "/HistogramData.php";

/**
 * Histogram test class.
 */
class HistogramTest extends TestCase
{
    /**
     * Test injecting one data class
     */
    public function testInjectDataOne()
    {
        $histogram = new Histogram();
        $serie = [1, 2, 3];
        $data = new HistogramData($serie);

        $histogram->injectData($data);

        $this->assertEquals($serie, $histogram->serie());
        $this->assertEquals(1, $histogram->min());
        $this->assertEquals(3, $histogram->max());
    }
    
    /**
     * Test injecting multiple data classes
     */
    public function testInjectData()
    {
        $histogram = new Histogram();
        $serie = [
            [1, 5],
            [3, 1, 4],
            [2],
        ];
        $data = array_map(function ($data) {
            return new HistogramData($data);
        }, $serie);


        $histogram->injectData(...$data);

        // Flatten the serie values
        $flatSerie = array_reduce($serie, function ($acc, $arr) {
            return array_merge($acc, $arr);
        }, []);

        $this->assertEquals($flatSerie, $histogram->serie());
        $this->assertEquals(1, $histogram->min());
        $this->assertEquals(5, $histogram->max());
    }
    
    /**
     * Test clearing histogram
     */
    public function testClearSerie()
    {
        $histogram = new Histogram();
        $serie = [1, 2, 3];
        $data = new HistogramData($serie);

        $histogram->injectData($data);

        // Check if serie is applied before we clear it
        $this->assertEquals($serie, $histogram->serie());

        // Hostogram should now be empty
        $histogram->clearSerie();
        $this->assertTrue(empty($histogram->serie()));
    }
}
