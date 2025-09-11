<?php
require_once '../library/motor.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    die("Debes iniciar sesión para comentar.");
}

// VALIDACIONES 
$usuario_id = $_SESSION['usuario_id'];
$contenido_id = $_GET['id'] ?? null;       
$tipo_contenido = $_GET['tipo'] ?? null;   
$comentario = trim($_POST['comentario'] ?? '');

if (!$contenido_id || !$tipo_contenido || empty($comentario)) {
    die("Datos incompletos.");
}

// INSERCIÓN DEL COMENTARIO
$sql = "INSERT INTO comentarios (usuario_id, contenido_id, tipo_contenido, comentario)
        VALUES (:usuario_id, :contenido_id, :tipo_contenido, :comentario)";

conexion::consulta($sql, [
    ':usuario_id' => $usuario_id,
    ':contenido_id' => $contenido_id,
    ':tipo_contenido' => $tipo_contenido,
    ':comentario' => $comentario
]);

// REDIRECCIÓN
if ($tipo_contenido === 'juego') {
    header("Location: ../web/detalle_juego.php?id=" . $contenido_id);
    exit;
} elseif ($tipo_contenido === 'anime') {
    header("Location: ../web/detalle_anime.php?id=" . $contenido_id);
    exit;
} else {
    die("Tipo de contenido desconocido.");
}
?>
