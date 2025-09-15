<?php
require_once "config.php"; 

class Plantilla {
    static $instancia = null;

    public static function aplicar() {
        if (self::$instancia === null) {
            self::$instancia = new Plantilla();
        }
        return self::$instancia;
    }

    public function __construct() {
        // 🔹 Iniciar sesión
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 🔹 Obtener ID de usuario
        $usuarioId = $_SESSION['usuario_id'] ?? null;
        $rol = null;

        // 🔹 Si hay usuario, obtener rol desde BD
        if ($usuarioId) {
            $resultado = conexion::consulta(
                "SELECT rol FROM usuarios WHERE id = :id",
                [":id" => $usuarioId]
            );
            $rol = $resultado[0]->rol ?? 'U';
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
                    <li><a href="../web/website.php">Inicio</a></li>
                    <li><a href="../web/games.php">Juegos</a></li>
                    <li><a href="../web/animes.php">Animes</a></li>
                    <li><a href="../web/about.php">Sobre mí</a></li>
                    <li><a href="../contact/index.php">Contacto</a></li>

                    <?php if ($usuarioId): ?>
                        <!-- Perfil dinámico -->
                        <li><a href="../web/perfil.php?id=<?php echo $usuarioId; ?>">Perfil</a></li>
                        <li><a href="../controllers/logout.php">Salir</a></li>
                    <?php else: ?>
                        <li><a href="../web/login.php">Iniciar sesión</a></li>
                    <?php endif; ?>

                    <!-- Solo administradores -->
                    <?php if ($rol === 'A'): ?>
                        <li><a href="../web/users_admin.php">Administración</a></li>
                    <?php endif; ?>
                </ul>
            </nav>

            <main>
        <?php
    }

    public function __destruct() {
    ?>
            </main>
        </body>

        <footer>
            <p>&copy; 2023 SoreWeb. Todos los derechos reservados.</p>
            <p>Desarrollado por <a href="https://github.com/fullmaps" target="_blank">rin_nightVT</a></p>
        </footer>
        </html>
    <?php
    }
}
