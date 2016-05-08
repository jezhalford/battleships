<?php
namespace Battleships\Tests\Game;

use Battleships\Game\Grid;
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
