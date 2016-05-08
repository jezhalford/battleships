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

    private $coveredSquares = array();

    private $targettedSquares = array(array());

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

        if (!isset($this->targettedSquares[$x])) {
            $this->targettedSquares[$x] = array();
        }

        $this->targettedSquares[$x][$y] = true;

        if (isset($this->coveredSquares[$x][$y]) && $this->coveredSquares[$x][$y] !== null) {
            $ship = $this->coveredSquares[$x][$y];
            $ship->hit();
            return $ship;
        }
    }
}
