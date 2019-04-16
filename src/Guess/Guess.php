<?php
namespace Faxity\Guess;

/**
 * Guess my number, a class supporting the game through GET, POST and SESSION.
 */
class Guess
{
    /**
     * @var int     $number  The current secret number.
     * @var int     $tries   Number of tries a guess has been made.
     * @var array   $guesses Array of all the guesses.
     */
    private $number;
    private $tries;
    private $guesses;



    /**
     * Constructor to initiate the object with current game settings,
     * if available. Randomize the current number if no value is sent in.
     *
     * @param int $number The current secret number, default -1 to initiate
     *                    the number from start.
     * @param int $tries  Number of tries a guess has been made,
     *                    default 6.
     */
    public function __construct(int $number = -1, int $tries = 6)
    {
        if ($number == -1) {
            $this->random();
        } else {
            $this->number = $number;
        }

        $this->tries = $tries;
        $this->guesses = [];
        $this->result = null;
        $this->cheat = false;
    }



    /**
     * Randomize the secret number between 1 and 100 to initiate a new game.
     *
     * @return void
     */
    public function random()
    {
        // Random int is slower than rand(), but less predictable
        $this->number = random_int(1, 100);
    }



    /**
     * Get number of tries left.
     *
     * @return int as number of tries made.
     */
    public function tries()
    {
        return $this->tries;
    }



    /**
     * Get the secret number.
     *
     * @return int as the secret number.
     */
    public function number()
    {
        return $this->number;
    }


    /**
     * An array for getting which numbers has been guessed
     * 
     * @return array as a list of integers.
     */
    public function guesses()
    {
        return $this->guesses;
    }


    /**
     * Gets which number was guessed last
     * 
     * @return int as a guessed number.
     */
    public function lastGuess()
    {
        $len = count($this->guesses);

        if ($len == 0) {
            return null;
        }

        return $this->guesses[$len - 1];
    }



    /**
     * Make a guess, decrease remaining guesses and return a string stating
     * if the guess was correct, too low or to high or if no guesses remains.
     * 
     * @throws GuessException when guessed number is out of bounds.
     *
     * @return string to show the status of the guess made.
     */
    public function makeGuess($number)
    {
        // Check if guess is out of bounds
        if ($number < 1 || $number > 100) {
            throw new GuessException("Guess is out of bounds!");
        } else if ($this->tries <= 0) {
            return "OUT OF GUESSES";
        }

        // Decrement remaining tries
        $this->tries -= 1;
        array_push($this->guesses, $number);

        if ($number > $this->number) {
            return "TOO HIGH";
        } else if ($number < $this->number) {
            return "TOO LOW";
        }

        return "CORRECT";
    }
}
