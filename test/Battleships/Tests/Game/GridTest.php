<?php
namespace Battleships\Tests\Game;

use Battleships\Game\Grid;
use Battleships\Game\Ship;
use PHPUnit_Framework_TestCase as TestCase;

class GridTest extends TestCase
{

    /**
     * @dataProvider        invalidConstructorParams
     */
    public function testGridConstructorThrowsExceptionOnInvalidParams($h, $w)
    {
        $this->setExpectedException('Battleships\Exception\GridException');
        $grid = new Grid($h, $w);
    }

    public function testGridConstructorSetsHeightAndWidth()
    {
        $h = 10;
        $w = 20;

        $grid = new Grid($h, $w);

        $this->assertEquals($h, $grid->getHeight());
        $this->assertEquals($w, $grid->getWidth());
    }

    public function testFiringAtAnEmptySquareReturnsNull()
    {
        $grid = new Grid(10, 10);
        $this->assertNull($grid->fireAtSquare(5, 5));
    }

    public function testFiringAtAPopulatedSquareReturnsShip()
    {
        $grid = new Grid(10, 10);
        $ship = new Ship(Ship::SHIP_AIRCRAFT_CARRIER, Ship::ORIENTATION_HORIZONTAL, 0, 0);

        $grid->placeShip($ship);
        $this->assertEquals($ship, $grid->fireAtSquare(0, 0));
    }

    public function testFiringAtTheSameSquareTwiceThrowsException()
    {
        $grid = new Grid(10, 10);
        $grid->fireAtSquare(0, 0);
        $this->setExpectedException('Battleships\Exception\FiringException');
        $grid->fireAtSquare(0, 0);
    }

    public function testSinking()
    {
        $grid = new Grid(10, 10);
        $ship = new Ship(Ship::SHIP_FRIGATE, Ship::ORIENTATION_HORIZONTAL, 0, 0);
        $grid->placeShip($ship);

        $this->assertEquals($ship, $grid->fireAtSquare(0, 0));
        $this->assertFalse($ship->isSunk());

        $this->assertEquals($ship, $grid->fireAtSquare(1, 0));
        $this->assertFalse($ship->isSunk());

        $this->assertEquals($ship, $grid->fireAtSquare(2, 0));
        $this->assertTrue($ship->isSunk());

    }


    /**
     * Data Provider for testGridConstructorThrowsExceptionOnInvalidParams
     */
    public function invalidConstructorParams()
    {
        return array(
            array('a', 'seven'),
            array(10, 'seven'),
            array('ten', 7),
            array(true, 10),
        );
    }
}
