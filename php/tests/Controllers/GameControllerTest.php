<?php

use Joc4enRatlla\Controllers\GameController;
use PHPUnit\Framework\TestCase;

class GameControllerTest extends TestCase
{
    private GameController $gameController;
    private $request;

    protected function setUp(): void
    {
        $this->request = ['name' => 'Player 1', 'color' => 'red'];
        $this->gameController = new GameController($this->request);
    }

    public function testGameInitialization()
    {
        $this->assertNotNull($this->gameController);
    }

    public function testPlayFunction()
    {
        $this->request['columna'] = 1;
        $this->gameController->play($this->request);

        $this->assertEquals(2, $this->gameController->getGame()->getNextPlayer());
    }

    public function testResetGame()
    {
        $this->request['reset'] = true;
        $this->gameController->play($this->request);

        $this->assertEquals(1, $this->gameController->getGame()->getNextPlayer());
    }

    public function testExitGame()
    {
        $this->request['exit'] = true;
        $this->gameController->play($this->request);

        $this->assertTrue(session_status() === PHP_SESSION_NONE);
    }
}
