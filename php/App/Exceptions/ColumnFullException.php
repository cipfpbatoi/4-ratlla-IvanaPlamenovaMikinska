<?php

namespace Joc4enRatlla\Exceptions;

/**
 * Excepció llançada quan un jugador intenta jugar en una columna plena.
 */
class ColumnFullException extends \Exception
{
    protected $message = 'La columna està plena. Intenta en una altra columna.';
}