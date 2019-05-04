<?php

namespace Faxity\Dice;

// Class used for testing the histogram class
class HistogramData implements HistogramInterface
{
    use HistogramTrait;

    public function __construct($serie)
    {
        $this->serie = $serie ?? [];
    }
}
