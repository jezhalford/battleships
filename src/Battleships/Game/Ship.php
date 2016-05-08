<?php
namespace Battleships\Game;

use Battleships\Exception\ShipException;

/**
 * Represents a ship, before or after placement on a grid
 */
class Ship
{

    const SHIP_SCOUT = 2;
    const SHIP_FRIGATE = 3;
    const SHIP_DESTROYER = 4;
    const SHIP_DREADNOUGHT = 5;
    const SHIP_AIRCRAFT_CARRIER = 6;

    const ORIENTATION_HORIZONTAL = 'h';
    const ORIENTATION_VERTICAL = 'v';


    private $type;

    private $orientation;

    private $positionX;

    private $positionY;

    public function __construct($type, $orientation, $positionX, $positionY)
    {
        if(!in_array($type, $this->validShipTypes())) {
            throw new ShipException('Ship type must be one of ' . implode(', ', $this->validShipTypes()));
        }

        if(!in_array($orientation, $this->validOrientations())) {
            throw new ShipException('Orientation must be one of ' . implode(', ', $this->validOrientations()));
        }

        if(!is_int($positionX) || !is_int($positionY) || $positionY < 0 || $positionX < 0) {
            throw new ShipException('Positions must be integers greater than or equal to zero');
        }

        $this->type = $type;
        $this->orientation = $orientation;
        $this->positionX = $positionX;
        $this->positionY = $positionY;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getLength()
    {
        return $this->getType();
    }

    public function getOrientation()
    {
        return $this->orientation;
    }

    public function getXPosition()
    {
        return $this->positionX;
    }

    public function getYPosition()
    {
        return $this->positionY;
    }

    public function getCoveredSquares()
    {
        $covered = array();

        if ($this->getOrientation() == self::ORIENTATION_HORIZONTAL) {
            for ($i = 0; $i < $this->getLength(); $i++) {
                $covered[] = array('x' => $this->getXPosition() + $i, 'y' => $this->getYPosition());
            }
        }

        if ($this->getOrientation() == self::ORIENTATION_VERTICAL) {
            for ($i = 0; $i < $this->getLength(); $i++) {
                $covered[] = array('x' => $this->getXPosition(), 'y' => $this->getYPosition() + $i);
            }
        }

        return $covered;
    }

    private function validShipTypes() {
        return array(
            self::SHIP_SCOUT,
            self::SHIP_FRIGATE,
            self::SHIP_DESTROYER,
            self::SHIP_DREADNOUGHT,
            self::SHIP_AIRCRAFT_CARRIER
        );
    }

    private function validOrientations() {
        return array(
            self::ORIENTATION_HORIZONTAL,
            self::ORIENTATION_VERTICAL
        );
    }

}
