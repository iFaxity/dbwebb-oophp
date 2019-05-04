<?php

namespace Faxity\Dice;

/**
 * A interface for a classes supporting histogram reports.
 */
interface HistogramInterface
{
    public function serieMin() : int;

    public function serieMax() : int;

    public function serie() : array;

    public function clearSerie() : void;
}
