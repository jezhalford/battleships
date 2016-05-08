<?php
namespace Battleships\Tests\Game;

use Battleships\Game\Ship;
use PHPUnit_Framework_TestCase as TestCase;

class ShipTest extends TestCase
{

    /**
     * @dataProvider        invalidConstructorParams
     */
    public function testGridConstructorThrowsExceptionOnInvalidParams($type, $orientation, $positionX, $positionY)
    {
        $this->setExpectedException('Battleships\Exception\ShipException');
        $grid = new Ship($type, $orientation, $positionX, $positionY);
    }

    public function testGridConstructorSetsValidValues()
    {
        $type = Ship::SHIP_DESTROYER;
        $orientation = Ship::ORIENTATION_HORIZONTAL;
        $positionX = 1;
        $positionY = 2;

        $ship = new Ship($type, $orientation, $positionX, $positionY);

        $this->assertEquals($type, $ship->getType());
        $this->assertEquals($orientation, $ship->getOrientation());
        $this->assertEquals($positionX, $ship->getXPosition());
        $this->assertEquals($positionY, $ship->getYPosition());
    }

    /**
     * @dataProvider        coveredSquaresProvider
     */
    public function testGetCoveredSquares($ship, $expectedCoveredSquares)
    {
        $coveredSquares = $ship->getCoveredSquares();

        foreach ($expectedCoveredSquares as $expectedCoveredSquare) {
            $this->assertContains($expectedCoveredSquare, $coveredSquares);
        }

        $this->assertCount(count($expectedCoveredSquares), $coveredSquares);
    }


    /**
     * Data Provider for testGridConstructorThrowsExceptionOnInvalidParams
     */
    public function invalidConstructorParams()
    {
        return array(
            array('x', 'y', 'z', 'a'),
            array(Ship::SHIP_DESTROYER, 'y', 'z', 'a'),
            array(Ship::SHIP_DESTROYER, Ship::ORIENTATION_HORIZONTAL, 'd', 'a'),
            array(Ship::SHIP_DESTROYER, Ship::ORIENTATION_HORIZONTAL, 1, 'a'),
        );
    }

    /**
     * Data Provider for testGetCoveredSquares
     */
    public function coveredSquaresProvider()
    {
        return array(
            array(
                new Ship(Ship::SHIP_DESTROYER, Ship::ORIENTATION_HORIZONTAL, 0, 0),
                array(
                    array('x' => 0, 'y' => 0),
                    array('x' => 1, 'y' => 0),
                    array('x' => 2, 'y' => 0),
                    array('x' => 3, 'y' => 0)
                )
            ),
            array(
                new Ship(Ship::SHIP_AIRCRAFT_CARRIER, Ship::ORIENTATION_VERTICAL, 0, 0),
                array(
                    array('x' => 0, 'y' => 0),
                    array('x' => 0, 'y' => 1),
                    array('x' => 0, 'y' => 2),
                    array('x' => 0, 'y' => 3),
                    array('x' => 0, 'y' => 4),
                    array('x' => 0, 'y' => 5)
                )
            )
        );
    }
}
