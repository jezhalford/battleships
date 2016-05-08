<?php
namespace Battleships\Tests\Game;

use Battleships\Game\Placement;
use Battleships\Game\Ship;
use Battleships\Game\Grid;
use PHPUnit_Framework_TestCase as TestCase;

class PlacementTest extends TestCase
{


    public function testShipTooLargeThrowsException()
    {
        $grid = new Grid(3, 3);
        $ship = new Ship(Ship::SHIP_AIRCRAFT_CARRIER, Ship::ORIENTATION_HORIZONTAL, 1, 1);

        $this->setExpectedException('Battleships\Exception\PlacementException');
        $grid->placeShip($ship);
    }

    public function testShipsOverlapThrowsException()
    {
        $grid = new Grid(10, 10);

        $shipA = new Ship(Ship::SHIP_AIRCRAFT_CARRIER, Ship::ORIENTATION_HORIZONTAL, 1, 1);
        $shipB = new Ship(Ship::SHIP_SCOUT, Ship::ORIENTATION_HORIZONTAL, 2, 1);

        $grid->placeShip($shipA);

        $this->setExpectedException('Battleships\Exception\PlacementException');
        $grid->placeShip($shipB);

    }

    public function testShipOverhangsGridHorizontallyThrowsException()
    {
        $grid = new Grid(10, 10);
        $ship = new Ship(Ship::SHIP_AIRCRAFT_CARRIER, Ship::ORIENTATION_HORIZONTAL, 8, 1);

        $this->setExpectedException('Battleships\Exception\PlacementException');
        $grid->placeShip($ship);

    }

    public function testShipOverhangsGridVerticallyThrowsException()
    {
        $grid = new Grid(10, 10);
        $ship = new Ship(Ship::SHIP_AIRCRAFT_CARRIER, Ship::ORIENTATION_VERTICAL, 1, 8);

        $this->setExpectedException('Battleships\Exception\PlacementException');
        $grid->placeShip($ship);

    }


}
