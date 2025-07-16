<?php

class Plantilla {
    static $instancia = null;

    public static function aplicar() {
        if (self::$instancia === null) {
            self::$instancia = new Plantilla();
        }
        return self::$instancia;
    }

    public function __construct() {
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
                <li><a href="../web/index.php">Inicio</a></li>
                <li><a href="../web/games.php">Juegos</a></li>
                <li><a href="../games/index.php">Animes</a></li>
                <li><a href="../aboutme/test.php">Sobre mí</a></li>
                <li><a href="../contact/index.php">Contacto</a></li>
            </ul>
        </nav>
        <?php
    }

    public function __destruct() {
        ?>
        <footer>
            <p>&copy; 2023 SoreWeb. Todos los derechos reservados.</p>
            <p>Desarrollado por <a href="https://github.com/fullmaps" target="_blank">rin_nightVT</a></p>
        </footer>
        </body>
        </html>
        <?php
    }
}
