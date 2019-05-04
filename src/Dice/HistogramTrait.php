<?php

namespace Faxity\Dice;

/**
 * A trait implementing HistogramInterface.
 */
trait HistogramTrait
{
    /**
     * @var array $serie The numbers stored in sequence.
     */
    private $serie = [];

    /**
     * Gets the minimum value in the serie
     * @return int.
     */
    public function serieMin() : int
    {
        return 1;
    }

    /**
     * Gets the max value in the serie
     * @return int.
     */
    public function serieMax() : int
    {
        return max($this->serie);
    }

    /**
     * Gets the series of values.
     * @return array with the serie.
     */
    public function serie() : array
    {
        return $this->serie;
    }

    /**
     * Clears the serie of tosses made this turn
     * @return void.
     */
    public function clearSerie() : void
    {
        $this->serie = [];
    }
}
