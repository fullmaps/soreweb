<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../web/login.php"); 
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../resources/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../design/stylewebsite.css">
    <title>SoreWeb</title>
</head>
<body>
    <nav class="navigation">
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="games.php">Juegos</a></li>
            <li><a href="animes.php">Animes</a></li>
            <li><a href="test.php">Sobre mí</a></li>
            <li><a href="../contact/">Contacto</a></li>
        </ul>
    </nav>
    <div class="grandcontainer">
         <div class="container">
            
        </div>
         <footer>
                <p>&copy; 2023 SoreWeb. Todos los derechos reservados.</p>
                <p>Desarrollado por <a href="github.com/fullmaps">rin_nightVT</a></p>
        </footer>
    </div>
   



    
</body>
</html>