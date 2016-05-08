<?php
namespace Battleships\Game;

use Battleships\Exception\PlacementException;
use Battleships\Game\Ship;
use Battleships\Game\Grid;

/**
 * Represents the placement of a ship on a grid
 */
class Placement
{

    private $ship;

    private $grid;

    public function __construct(Ship $ship, Grid $grid)
    {
        $this->ship = $ship;
        $this->grid = $grid;

        if (!$this->shipFitsOnGrid()) {
            throw new PlacementException('Ship is too large for the grid');
        }

        if (!$this->shipIsWithinGrid()) {
            throw new PlacementException('Ship overhangs the grid');
        }

        if (!$this->shipIsInClearWater()) {
            throw new PlacementException('Ship overlaps another already placed');
        }
    }

    public function getShip()
    {
        return $this->ship;
    }

    /**
     * Returns false if the ship won't fit on the grid
     */
    private function shipFitsOnGrid()
    {
        $shipIsHoriz = ($this->ship->getOrientation() == Ship::ORIENTATION_HORIZONTAL);
        $shipIsLongerThanGridIsWide = $this->ship->getLength() > $this->grid->getWidth();
        $shipIsLongerThanGridIsTall = $this->ship->getLength() > $this->grid->getHeight();

        if ($shipIsHoriz && $shipIsLongerThanGridIsWide) {
            return false;
        }

        if (!$shipIsHoriz && $shipIsLongerThanGridIsTall) {
            return false;
        }

        return true;
    }

    /**
     * Returns false if the ship overhangs the grid
     */
    private function shipIsWithinGrid()
    {
        $shipIsHoriz = ($this->ship->getOrientation() == Ship::ORIENTATION_HORIZONTAL);
        $shipLength = $this->ship->getLength();
        $gridWidth = $this->grid->getWidth();
        $gridHeight = $this->grid->getHeight();
        $xPosition = $this->ship->getXPosition();
        $yPosition = $this->ship->getYPosition();


        if ($shipIsHoriz) {
            if (($shipLength + $xPosition) > $gridWidth) {
                return false;
            }
        } else {
            if (($shipLength + $yPosition) > $gridHeight) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns false if the ship overlaps another that's already on the grid
     */
    private function shipIsInClearWater()
    {
        $coveredByNewShip = $this->ship->getCoveredSquares();

        foreach ($this->grid->getPlacements() as $placement) {
            $alreadyCovered = $placement->getShip()->getCoveredSquares();

            foreach ($coveredByNewShip as $squareCoveredByNewShip) {
                if (in_array($squareCoveredByNewShip, $alreadyCovered)) {
                    return false;
                }
            }
        }

        return true;
    }
}
