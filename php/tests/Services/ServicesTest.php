<?php

use Joc4enRatlla\Services\Service;
use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $_SERVER['DOCUMENT_ROOT'] = '/path/a/tu/proyecto';
    }

    public function testLoadViewLoadsCorrectView()
    {
        ob_start();

        Service::loadView('jugador', ['title' => 'Inicio de sesión']);

        $output = ob_get_clean();

        $this->assertStringContainsString('Inicio de sesión', $output);
    }
}
