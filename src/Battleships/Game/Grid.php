<?php
namespace Battleships\Game;

use Battleships\Game\Ship;
use Battleships\Game\Placement;
use Battleships\Exception\GridException;

/**
 * Represents a game grid
 */
class Grid
{

    private $height;
    private $width;

    private $placements = array();

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
    }
}
