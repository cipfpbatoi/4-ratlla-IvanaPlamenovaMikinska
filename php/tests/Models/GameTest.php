<?php

use Joc4enRatlla\Models\Game;
use Joc4enRatlla\Models\Player;
use Joc4enRatlla\Models\Board;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    private Game $game;
    private Player $player1;
    private Player $player2;

    protected function setUp(): void
    {
        $this->player1 = new Player('Player 1', 'red');
        $this->player2 = new Player('Player 2', 'blue');
        $this->game = new Game($this->player1, $this->player2);
    }

    public function testInitialGameSetup()
    {
        $this->assertInstanceOf(Board::class, $this->game->getBoard());
        $this->assertEquals(1, $this->game->getNextPlayer());
        $this->assertEquals(0, $this->game->getScores()[1]);
        $this->assertEquals(0, $this->game->getScores()[2]);
    }

    public function testPlay()
    {
        $this->game->play(1);
        $this->assertEquals(2, $this->game->getNextPlayer()); 
    }

    public function testIncrementScore()
    {
        $this->game->incrementScore(1);
        $this->assertEquals(1, $this->game->getScores()[1]);
    }

    public function testReset()
    {
        $this->game->play(1); 
        $this->game->reset();
        $this->assertEquals(1, $this->game->getNextPlayer()); 
        $this->assertNull($this->game->getWinner());
    }

    public function testPlayAutomatic()
    {
        $this->game->playAutomatic();
    }

    public function testSaveAndRestore()
    {
        $this->game->save();
        $restoredGame = Game::restore();
        $this->assertEquals($this->game->getNextPlayer(), $restoredGame->getNextPlayer());
        $this->assertEquals($this->game->getScores(), $restoredGame->getScores());
    }
}
