<?php

namespace Joc4enRatlla\Models;

use Joc4enRatlla\Exceptions\ColumnFullException;

/**
 * Representación del tablero del juego '4 en Ratlla'
 */
class Board
{
    public const FILES = 6;
    public const COLUMNS = 7;
    public const DIRECTIONS = [
        [0, 1],   // Horizontal derecha
        [1, 0],   // Vertical abajo
        [1, 1],   // Diagonal abajo-derecha
        [1, -1]   // Diagonal abajo-izquierda
    ];

    /**
     * @var array $slots Matriz de posiciones del tablero
     */
    private array $slots; // graella


    /**
     * Constructor que inicializa el tablero vacío.
     */
    public function __construct()
    {
        // TODO: Ha d'inicializar $slots
        $this->slots = $this->initializeBoard();
    }

    // TODO: Getters i Setters 

    /**
     * Obtiene las posiciones del tablero.
     * 
     * @return array Matriz de posiciones
     */
    public function getSlots()
    {
        return $this->slots;
    }

    /**
     * Inicializa la matriz del tablero con valores vacíos.
     * 
     * @return array Tablero inicializado
     */
    private static function initializeBoard(): array
    {
        // TODO: Inicialitza la graella amb valors buits
        return array_fill(1, self::FILES, array_fill(1, self::COLUMNS, 0));
    }


    /**
     * Realiza un movimiento en el tablero.
     * 
     * @param int $column Columna seleccionada
     * @param int $player Jugador que realiza el movimiento
     * @return array Coordenadas del movimiento realizado
     */
    public function setMovementOnBoard(int $column, int $player): array
    {
        // TODO: Realitza un moviment en la graella
        try{
            for ($i = self::FILES; $i > 0; $i--) {
            if ($this->slots[$i][$column] === 0) {
                $this->slots[$i][$column] = $player;
                return [$i, $column];
            }
        }
        return [-1, -1];
        } catch (ColumnFullException $e) {
            $e->getMessage();
        }
        
    }


    /**
     * Verifica si hay un ganador en el tablero.
     * 
     * @param array $coord Coordenadas del último movimiento
     * @return bool true si hay un ganador, false en caso contrario
     */
    public function checkWin(array $coord): bool
    {
        // TODO: Comprova si hi ha un guanyador
        foreach (self::DIRECTIONS as $direction) {
            $count = 1;
            foreach ([-1, 1] as $step) {
                $i = $coord[0];
                $j = $coord[1];
                while (true) {
                    $i += $direction[0] * $step;
                    $j += $direction[1] * $step;
                    if ($i <= 0 || $i > self::FILES || $j <= 0 || $j > self::COLUMNS || $this->slots[$i][$j] !== $this->slots[$coord[0]][$coord[1]]) {
                        break;
                    }
                    $count++;
                }
            }
            if ($count >= 4) {
                return true;
            }
        }
        return false;
    }


    /**
     * Verifica si un movimiento en una columna es válido.
     * 
     * @param int $column Columna seleccionada
     * @return bool true si el movimiento es válido, false en caso contrario
     */
    public function isValidMove(int $column): bool
    {
        // TODO: Comprova si el moviment és vàlid
        return $this->slots[1][$column] === 0;
    }


    /**
     * Verifica si el tablero está lleno.
     * 
     * @return bool true si el tablero está lleno, false en caso contrario
     */
    public function isFull(): bool
    {
        // TODO: El tauler està ple?
        foreach ($this->slots[0] as $cell) {
            if ($cell === 0)
                return false;
        }
        return true;
    }
}
