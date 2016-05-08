<?php
namespace Battleships\Game;

use Battleships\Game\Ship;
use Battleships\Game\Placement;
use Battleships\Exception\GridException;
use Battleships\Exception\FiringException;

/**
 * Represents a game grid
 */
class Grid
{

    private $height;

    private $width;

    private $placements = array();

    /**
     * 2D array where each populated square contains a reference to the populating ship
     */
    private $coveredSquares = array();

    /**
     * 2D array where each targetted square is set to true
     */
    private $targettedSquares = array();

    private $shots = 0;

    private $hits = 0;

    private $sinkings = 0;


    public function __construct($height, $width)
    {

        if(!is_int($height) || !is_int($width) || $width < 1 || $height < 1) {
            throw new GridException('Grid height and width must be positive integers');
        }

        $this->height = $height;
        $this->width = $width;

    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getPlacements()
    {
        return $this->placements;
    }

    /**
     * Add a ship to the game grid
     */
    public function placeShip(Ship $ship)
    {
        $this->placements[] = new Placement($ship, $this);

        foreach ($ship->getCoveredSquares() as $covered) {
            $this->coveredSquares[$covered['x']][$covered['y']] = $ship;
        }

    }

    /**
     * Returns ship if hit
     */
    public function fireAtSquare($x, $y)
    {
        if (isset($this->targettedSquares[$x]) && isset($this->targettedSquares[$x][$y]) && $this->targettedSquares[$x][$y] === true) {
            throw new FiringException('You have already fired at this square');
        }

        $this->shots++;

        if (!isset($this->targettedSquares[$x])) {
            $this->targettedSquares[$x] = array();
        }

        $this->targettedSquares[$x][$y] = true;

        if (isset($this->coveredSquares[$x][$y]) && $this->coveredSquares[$x][$y] !== null) {
            $ship = $this->coveredSquares[$x][$y];
            $ship->hit();
            $this->hits++;

            if ($ship->isSunk()) {
                $this->sinkings++;
            }

            return $ship;
        }
    }

    public function getShotsFired()
    {
        return $this->shots;
    }

    public function getHits()
    {
        return $this->hits;
    }

    public function getSinkings()
    {
        return $this->sinkings;
    }
}
