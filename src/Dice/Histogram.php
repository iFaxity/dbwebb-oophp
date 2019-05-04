<?php

namespace Faxity\Dice;

class Histogram {
    private $min;
    private $max;
    private $serie;

    public function renderHistogram()
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
     * Clears the serie of tosses
     * @return void.
     */
    public function clearSerie() : void
    {
        $this->serie = [];
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
