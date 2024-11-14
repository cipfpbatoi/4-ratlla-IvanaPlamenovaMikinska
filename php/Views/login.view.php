<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="/php/src/4ratlla.css">
</head>

<body>
    <h1>Iniciar Sesión</h1>
    <form action="login.php" method="post">
        <label for="nom_usuari">Nombre de Usuario:</label>
        <input type="text" id="nom_usuari" name="nom_usuari" required><br><br>

        <label for="contrasenya">Contraseña:</label>
        <input type="password" id="contrasenya" name="contrasenya" required><br><br>

        <button type="submit">Login</button>
    </form>
</body>

</html>