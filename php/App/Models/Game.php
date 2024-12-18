<?php

namespace Joc4enRatlla\Models;

use Joc4enRatlla\Models\Board;
use Joc4enRatlla\Models\Player;
use Joc4enRatlla\Services\Database;
use PDO;

/**
 * La clase Game representa una partida de 4 en Ratlla.
 */
class Game
{
    private Board $board;
    private int $nextPlayer;
    private array $players;
    private ?Player $winner;
    private array $scores;

    /**
     * Inicia una nueva partida.
     *
     * @param Player $player1 Jugador 1.
     * @param Player $player2 Jugador 2.
     */
    public function __construct(Player $jugador1, Player $jugador2)
    {
        // TODO: S'han d'inicialitzar les variables tenint en compte que el array de jugador ha de començar amb l'index 1 
        $this->board = new Board();
        $this->nextPlayer = 1;
        $this->players = [1 => $jugador1, 2 => $jugador2];
        $this->winner = null;
        $this->scores = [1 => 0, 2 => 0];
    }

    // TODO: getters i setters

    public function getBoard()
    {
        return $this->board;
    }

    public function setBoard(Board $board)
    {
        $this->board = $board;
    }

    public function getNextPlayer()
    {
        return $this->nextPlayer;
    }

    public function setNextPlayer(int $nextPlayer)
    {
        $this->nextPlayer = $nextPlayer;
    }

    public function getPlayers()
    {
        return $this->players;
    }

    public function setPlayers(array $players)
    {
        $this->players = $players;
    }

    public function getPlayer(int $index)
    {
        return $this->players[$index];
    }

    public function setPlayer(int $index, Player $player)
    {
        $this->players[$index] = $player;
    }

    public function getWinner()
    {
        return $this->winner;
    }

    public function setWinner(?Player $winner)
    {
        $this->winner = $winner;
    }

    public function getScores()
    {
        return $this->scores;
    }

    public function setScores(array $scores)
    {
        $this->scores = $scores;
    }


    public function incrementScore(int $playerIndex): void
    {
        if (isset($this->scores[$playerIndex])) {
            $this->scores[$playerIndex]++;
        }
    }

    public function reset(): void
    {
        // TODO: Reinicia el joc
        $this->board = new Board();
        $this->winner = null;
        $this->nextPlayer = 1;
        $this->save();
    }


    public function play($columna)
    {
        // TODO: Realitza un moviment
        if ($this->board->isValidMove($columna)) {
            $coordenadas = $this->board->setMovementOnBoard($columna, $this->nextPlayer);

            if ($this->board->checkWin($coordenadas)) {
                $this->winner = $this->players[$this->nextPlayer];
            }

            $this->nextPlayer = $this->nextPlayer === 1 ? 2 : 1;
        }
    }


    /**
     * Realitza moviment automàtic
     * @return void
     */
    public function playAutomatic()
    {
        $opponent = $this->nextPlayer === 1 ? 2 : 1;

        for ($col = 1; $col <= Board::COLUMNS; $col++) {
            if ($this->board->isValidMove($col)) {
                $tempBoard = clone ($this->board);
                $coord = $tempBoard->setMovementOnBoard($col, $this->nextPlayer);

                if ($tempBoard->checkWin($coord)) {
                    $this->play($col);
                    return;
                }
            }
        }

        for ($col = 1; $col <= Board::COLUMNS; $col++) {
            if ($this->board->isValidMove($col)) {
                $tempBoard = clone ($this->board);
                $coord = $tempBoard->setMovementOnBoard($col, $opponent);
                if ($tempBoard->checkWin($coord)) {
                    $this->play($col);
                    return;
                }
            }
        }

        $possibles = array();
        for ($col = 1; $col <= Board::COLUMNS; $col++) {
            if ($this->board->isValidMove($col)) {
                $possibles[] = $col;
            }
        }
        if (count($possibles) > 2) {
            $random = rand(-1, 1);
        }
        $middle = (int) (count($possibles) / 2) + $random;
        $inthemiddle = $possibles[$middle];
        $this->play($inthemiddle);
    }


    public function save()
    {
        // TODO: Guarda l'estat del joc a les sessions
        $_SESSION['game'] = serialize($this);
    }


    public static function restore()
    {
        // TODO: Restaura l'estat del joc de les sessions
        return unserialize($_SESSION['game'], [Game::class]) ?? null;
    }

    public function saveToDatabase($userId)
    {
        $db = new Database();
        $conn = $db->connect();
    
        $gameData = [
            'estado_partida' => serialize($this->board),
            'scores' => $this->scores
        ];
    
        $gameJson = serialize($this);
    
        $stmt = $conn->prepare(
            "INSERT INTO partides (usuari_id, game) VALUES (:usuari_id, :game)
            ON DUPLICATE KEY UPDATE game = :game"
        );
        $stmt->bindParam(':usuari_id', $userId);
        $stmt->bindParam(':game', $gameJson);
    
        $stmt->execute();
    }

    public static function loadFromDatabase($userId)
    {
        $db = new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("SELECT game FROM partides WHERE usuari_id = :usuari_id");
        $stmt->bindParam(':usuari_id', $userId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return unserialize($result['game'], [Game::class]);
        }

        return null;
    }
}
