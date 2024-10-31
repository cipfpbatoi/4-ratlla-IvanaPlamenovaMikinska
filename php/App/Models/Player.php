<?php

namespace Joc4enRatlla\Models;

/**
 * Representa a un jugador del juego '4 en Ratlla'
 */
class Player
{
    private $name;      // Nom del jugador
    private $color;     // Color de les fitxes
    private $isAutomatic; // Forma de jugar (automàtica/manual)


    /**
     * Constructor del jugador.
     * 
     * @param string $name Nombre del jugador
     * @param string $color Color del jugador
     */
    public function __construct($name, $color, $isAutomatic = false)
    {
        // TODO: Inicialitzar variables 
        $this->name = $name;
        $this->color = $color;
        $this->isAutomatic = $isAutomatic;
    }

    // TODO: Getters i Setters 

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor(string $color)
    {
        $this->color = $color;
    }

    public function isAutomatic()
    {
        return $this->isAutomatic;
    }

    public function setAutomatic(bool $isAutomatic)
    {
        $this->isAutomatic = $isAutomatic;
    }
}
