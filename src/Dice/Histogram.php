<?php

namespace Faxity\Dice;

class Histogram
{
    private $min;
    private $max;
    private $serie;

    /**
     * Gets the minimum value in the serie
     * @return int.
     */
    public function min() : int
    {
        return $this->min;
    }

    /**
     * Gets the maximum value in the serie
     * @return int.
     */
    public function max() : int
    {
        return $this->max;
    }

    /**
     * Gets the serie
     * @return array.
     */
    public function serie() : array
    {
        return $this->serie;
    }

    /**
     * Clears the serie of tosses
     * @return void.
     */
    public function clearSerie() : void
    {
        $this->serie = [];
    }


    /**
     * Renders the histogram as html
     * @return string.
     */
    public function renderHistogram() : string
    {
        $min = $this->min;
        $max = $this->max;
        $res = "";

        // Count every occurrence
        $occurences = array_fill($min, 1 + $max - $min, "");

        foreach ($this->serie as $value) {
            if ($value >= $min && $value <= $max) {
                $occurences[$value] .= "*";
            }
        }

        for ($i = $min; $i <= $max; $i++) {
            $value = $occurences[$i];

            $res .= "{$i}: {$value}\n";
        }

        return "<pre>{$res}</pre>";
    }

    /**
     * Injects data from HistogramInterfaces
     */
    public function injectData(HistogramInterface ...$objects) : void
    {
        // Clear serie before continuing
        $min = [];
        $max = [];

        $this->serie = array_reduce($objects, function ($acc, $obj) use (&$min, &$max) {
            $serie = $obj->serie();

            if (!empty($serie)) {
                $min[] = $obj->serieMin();
                $max[] = $obj->serieMax();

                return array_merge($acc, $serie);
            }

            return $acc;
        }, []);

        $this->min = min($min);
        $this->max = max($max);
    }
}
