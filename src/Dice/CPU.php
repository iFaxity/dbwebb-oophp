<?php

namespace Faxity\Dice;

/**
 * Class to represent a sentient player, who makes choices on its own
 */
class CPU extends Player
{
    /**
     * Checks if its probable there is not a 1 in the next toss
     * Probability = sides / sides^2
     * @return bool.
     */
    public function shouldEndTurn() : bool
    {
        // We dont want to play on exact probability, i added a + 2 to play more safely
        $oneCount = count(array_keys(self::$serie, 1, true));
        $prob = 1 / (Dice::SIDES + 2);

        // only chance if its likely a one wont show up, based on past occurences
        return ($oneCount / count(self::$serie)) <= $prob;
    }

    /**
     * Tosses the dice until it's not probable
     * or until we get a 1, then turnScore is reset
     * @return void.
     */
    public function toss() : void
    {
        while (true) {
            parent::toss();

            // If we lost the turn, we pass it over
            // Play on probability, for a more steady safe game
            if ($this->turnScore == 0 || $this->shouldEndTurn()) {
                break;
            }
        }

        $this->endTurn();
    }
}
