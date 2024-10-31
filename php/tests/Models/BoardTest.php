<?php

use Joc4enRatlla\Models\Board;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    private Board $board;

    protected function setUp(): void
    {
        $this->board = new Board();
    }

    public function testInitialBoardIsEmpty()
    {
        $slots = $this->board->getSlots();
        for ($i = 1; $i <= Board::FILES; $i++) {
            for ($j = 1; $j <= Board::COLUMNS; $j++) {
                $this->assertEquals(0, $slots[$i][$j]);
            }
        }
    }

    public function testSetMovementOnBoard()
    {
        $this->board->setMovementOnBoard(1, 1);
        $this->assertEquals(1, $this->board->getSlots()[5][1]);
    }

    public function testValidMove()
    {
        $this->assertTrue($this->board->isValidMove(1));
        $this->board->setMovementOnBoard(1, 1);
        $this->assertFalse($this->board->isValidMove(1));
    }

    public function testCheckWin()
    {
        $this->board->setMovementOnBoard(1, 1);
        $this->board->setMovementOnBoard(2, 1);
        $this->board->setMovementOnBoard(3, 1);
        $this->board->setMovementOnBoard(4, 1);
        
        $this->assertTrue($this->board->checkWin([5, 1])); 
    }

    public function testIsFull()
    {
        for ($j = 1; $j <= Board::COLUMNS; $j++) {
            for ($i = 1; $i <= Board::FILES; $i++) {
                $this->board->setMovementOnBoard($j, 1);
            }
        }
        $this->assertTrue($this->board->isFull());
    }
}
