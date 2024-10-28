<html>

<head>
    <link rel="stylesheet" href="4ratlla.css?v=<?php echo time(); ?>">
    <title>4 en ratlla</title>
    <style>
        .player1 {
            background-color: <?= $players[1]->getColor() ?>;
            /* Color   per un dels jugadors */
        }

        .player2 {
            background-color: <?= $players[2]->getColor() ?>;
            /* Color   per l'altre jugador */
        }
    </style>
</head>

<body>

    <div class="scores">
        <h2>Marcador</h2>
        <b>
            <p><?= $players[1]->getName() ?>
        </b>: <?= $scores[1] ?> victorias</p>
        <b>
            <p><?= $players[2]->getName() ?>
        </b>: <?= $scores[2] ?> victorias</p>
    </div>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/../Views/partials/error.view.php'  ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/../Views/partials/board.view.php'  ?>
        <input type="submit" name="reset" value="Reiniciar joc">
        <input type="submit" name="exit" value="Acabar joc">
    </form>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/../Views/partials/panel.view.php'  ?>
</body>

</html>