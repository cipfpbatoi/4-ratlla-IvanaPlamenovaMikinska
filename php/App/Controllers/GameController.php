<?php

namespace Joc4enRatlla\Controllers;

use Joc4enRatlla\Models\Player;
use Joc4enRatlla\Models\Game;
use Joc4enRatlla\Services\Service;

class GameController
{
    private Game $game;

    // Request és l'array $_POST

    public function __construct($request = null)
    {
        // TODO: Inicialització del joc.Ha d'inicializar el Game si és la primera vegada o agafar les dades de la sessió si ja ha estat inicialitzada

        if (isset($_SESSION['game'])) {
            $this->game = Game::restore();
        } else {
            $player1 = new Player($request['name'], $request['color']);
            $player2 = new Player('Automatic','pink');
            $this->game = new Game($player1, $player2);
            $this->game->save();
        }
        $this->play($request);
    }

    public function play(array $request)
    {
        // TODO : Gestió del joc. Ací es on s'ha de vore si hi ha guanyador, si el que juga es automàtic  o manual, s'ha polsat reiniciar...

        if (isset($request['columna'])) {
            $column = (int) $request['columna'];
            $this->game->play($column);

            $winner = $this->game->getWinner();
            if ($winner) {
                $winnerIndex = ($winner === $this->game->getPlayer(1)) ? 1 : 2;
                $this->game->incrementScore($winnerIndex);
            }

            $this->game->save();
        }

        if(isset($request['exit'])) {
            session_destroy();
            Service::loadView('jugador');
            return;
        }

        if (isset($request['reset'])) {
            $this->game->reset();
        }

        $board = $this->game->getBoard();
        $players = $this->game->getPlayers();
        $winner = $this->game->getWinner();
        $scores = $this->game->getScores();

        loadView('index', compact('board', 'players', 'winner', 'scores'));
    }
}
