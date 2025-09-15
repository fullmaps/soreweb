<?php
require_once '../library/motor.php';

session_start();

// Validar sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../web/login.php"); 
    exit;
}

$usuarioid = $_SESSION['usuario_id'];

// Validar ID en URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "⚠️ ID de usuario no válido.";
    exit;
}

$idPerfil = (int)$_GET['id'];

// Consultar usuario + perfil
$sql = "SELECT u.id, u.nombre, u.correo, u.fecha_creacion, u.activo, u.rol,
               p.descripcion, p.foto AS foto_perfil, p.background, p.carta
        FROM usuarios u
        LEFT JOIN perfil p ON u.id = p.usuario_id
        WHERE u.id = ?";
$resultado = conexion::consulta($sql, [$idPerfil]);

if (count($resultado) === 0) {
    echo "⚠️ Usuario no encontrado.";
    exit;
}

$usuario = $resultado[0]; // viene como objeto por FETCH_OBJ

Plantilla::aplicar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/perfil.css">
</head>
<body>
    <section class="perfil-container" 
        style="background-image: url('<?php echo $usuario->background ?: "../design/default-bg.jpg"; ?>');">

        <h1 class="perfil-titulo"><?php echo htmlspecialchars($usuario->nombre); ?></h1>

        <div class="perfil-card <?php echo $usuario->carta ?: ''; ?>">
            <img src="<?php echo $usuario->foto_perfil ?: '../resources/gonermaker.png'; ?>" 
                 alt="Foto de perfil" class="perfil-avatar">

            <p><strong>Correo:</strong> <?php echo htmlspecialchars($usuario->correo); ?></p>
            <p><strong>Rol:</strong> <?php echo ($usuario->rol === 'A') ? "Administrador" : "Usuario"; ?></p>
            <p><strong>Estado:</strong> <?php echo $usuario->activo ? "Activo " : "Inactivo "; ?></p>
            <p><strong>Miembro desde:</strong> <?php echo $usuario->fecha_creacion; ?></p>

            <?php if (!empty($usuario->descripcion)): ?>
                <p><strong>Acerca de mí:</strong> <?php echo htmlspecialchars($usuario->descripcion); ?></p>
            <?php endif; ?>

        </div>

                <?php if ($usuarioid === $idPerfil): ?>
                <a class="btn-deltarune" href="personalizar.php?id=<?php echo $idPerfil; ?>">
                    Personalizar perfil
                </a>
            <?php endif; ?>
    </section>
</body>
</html>
