<?php

use Joc4enRatlla\Models\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    private Player $player;

    protected function setUp(): void
    {
        $this->player = new Player('Test Player', 'red');
    }

    public function testPlayerInitialization()
    {
        $this->assertEquals('Test Player', $this->player->getName());
        $this->assertEquals('red', $this->player->getColor());
        $this->assertFalse($this->player->isAutomatic());
    }

    public function testSetPlayerName()
    {
        $this->player->setName('New Name');
        $this->assertEquals('New Name', $this->player->getName());
    }

    public function testSetPlayerColor()
    {
        $this->player->setColor('blue');
        $this->assertEquals('blue', $this->player->getColor());
    }

    public function testSetPlayerAutomatic()
    {
        $this->player->setAutomatic(true);
        $this->assertTrue($this->player->isAutomatic());
    }
}
