<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../Helpers/functions.php';

use Joc4enRatlla\Services\Database;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomUsuari = $_POST['nom_usuari'];
    $contrasenya = $_POST['contrasenya'];

    $db = new Database();
    $conn = $db->connect();

    $stmt = $conn->prepare("SELECT * FROM usuaris WHERE nom_usuari = :nom_usuari");
    $stmt->bindParam(':nom_usuari', $nomUsuari);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        if (password_verify($contrasenya, $user['contrasenya'])) {
            $_SESSION['usuari_id'] = $user['id'];
            header("Location: index.php");
            exit;
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        $hashedPassword = password_hash($contrasenya, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO usuaris (nom_usuari, contrasenya) VALUES (:nom_usuari, :contrasenya)");
        $stmt->bindParam(':nom_usuari', $nomUsuari);
        $stmt->bindParam(':contrasenya', $hashedPassword);
        $stmt->execute();

        $_SESSION['usuari_id'] = $conn->lastInsertId();
        header("Location: index.php");
        exit;
    }
} else {
    loadView("login");
}
