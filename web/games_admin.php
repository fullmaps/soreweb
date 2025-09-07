<?php
require_once '../library/motor.php';
Plantilla::aplicar();

$errores = [];
$exito = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre        = trim($_POST['nombre'] ?? '');
    $descripcion   = trim($_POST['descripcion'] ?? '');
    $horas         = trim($_POST['horas'] ?? '');
    $dificultad    = trim($_POST['dificultad'] ?? '');
    $estado        = trim($_POST['estado'] ?? '');
    $rating        = intval($_POST['rating'] ?? 0);
    $rating_custom = trim($_POST['rating_custom'] ?? '');
    $imagen        = $_FILES['imagen']['name'] ?? '';

    // Validaciones básicas
    if ($nombre === '') $errores[] = "El nombre es obligatorio.";
    if ($descripcion === '') $errores[] = "La descripción es obligatoria.";

    $nombreArchivoFinal = null;

    if ($imagen) {
        $ext = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($ext, $permitidas)) {
            $errores[] = "Formato de imagen no permitido.";
        } else {
            $nombreArchivoFinal = 'game_' . time() . '.' . $ext;

            // Ruta absoluta a resources
            $carpeta = realpath(__DIR__ . '/../resources');
            if (!$carpeta) {
                $errores[] = "No se encontró la carpeta resources.";
            } else {
                $destino = $carpeta . DIRECTORY_SEPARATOR . $nombreArchivoFinal;

                if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
                    $errores[] = "Error al guardar la imagen en $destino. Revisa permisos.";
                }
            }
        }
    }

    // Guardar en la base de datos si no hubo errores
    if (!$errores) {
        conexion::exec(
            "INSERT INTO juegos (nombre, descripcion, imagen, horas, dificultad, estado, rating, rating_custom, creado_en) 
            VALUES (:nombre, :descripcion, :imagen, :horas, :dificultad, :estado, :rating, :rating_custom, NOW())",
            [
                ':nombre'        => $nombre,
                ':descripcion'   => $descripcion,
                ':imagen'        => $nombreArchivoFinal,
                ':horas'         => $horas,
                ':dificultad'    => $dificultad,
                ':estado'        => $estado,
                ':rating'        => $rating,
                ':rating_custom' => $rating_custom
            ]
        );
        $exito = "Juego registrado correctamente 🎉";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/game_register.css">
</head>


<h2 style="color:#25FF08;text-align:center;margin-top:20px">Registrar Juego</h2>

<?php if ($exito): ?>
    <div style="background:#d4edda;color:#155724;padding:10px;margin:15px auto;width:60%;border-radius:5px;">
        <?= htmlspecialchars($exito) ?>
    </div>
<?php endif; ?>

<?php if ($errores): ?>
    <div style="background:#f8d7da;color:#721c24;padding:10px;margin:15px auto;width:60%;border-radius:5px;">
        <ul>
            <?php foreach ($errores as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" enctype="multipart/form-data" style="width:60%;margin:20px auto;background:#111;color:#fff;padding:20px;border-radius:10px">
    <label>Nombre:</label><br>
    <input type="text" name="nombre" style="width:100%;padding:8px;margin:5px 0"><br><br>

    <label>Descripción:</label><br>
    <textarea name="descripcion" rows="4" style="width:100%;padding:8px;margin:5px 0"></textarea><br><br>

    <label>Imagen:</label><br>
    <input type="file" name="imagen" style="margin:5px 0"><br><br>

    <label>Horas jugadas:</label><br>
    <input type="text" name="horas" style="width:100%;padding:8px;margin:5px 0"><br><br>

    <label>Dificultad:</label><br>
    <select name="dificultad" style="width:100%;padding:8px;margin:5px 0">
        <option value="">-- Seleccionar --</option>
        <option value="Fácil">Fácil</option>
        <option value="Normal">Normal</option>
        <option value="Difícil">Difícil</option>
        <option value="Extremo">Extremo</option>
    </select><br><br>

    <label>Estado:</label><br>
    <select name="estado" style="width:100%;padding:8px;margin:5px 0">
        <option value="">-- Seleccionar --</option>
        <option value="En progreso">En progreso</option>
        <option value="Terminado">Terminado</option>
        <option value="Abandonado">Abandonado</option>
        <option value="Pendiente">Pendiente</option>
    </select><br><br>

    <label>Rating (1 a 5):</label><br>
    <input type="number" name="rating" min="1" max="5" style="width:100%;padding:8px;margin:5px 0"><br><br>

    <label>Rating personalizado (URL o nombre de imagen):</label><br>
    <input type="text" name="rating_custom" style="width:100%;padding:8px;margin:5px 0" placeholder="ej: estrella.png o https://..."><br><br>

    <button type="submit" class="btn-deltarune">
        Guardar
    </button>
</form>
</html>