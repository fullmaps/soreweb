<?php
require_once '../library/motor.php';
Plantilla::aplicar();

$errores = [];
$exito = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre      = trim($_POST['nombre'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $imagen      = $_FILES['imagen']['name'] ?? '';

    if ($nombre === '') $errores[] = "El nombre es obligatorio.";
    if ($descripcion === '') $errores[] = "La descripción es obligatoria.";

    $nombreArchivoFinal = null;

    if ($imagen) {
        $ext = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));
        $permitidas = ['jpg','jpeg','png','gif','webp'];
        if (!in_array($ext, $permitidas)) $errores[] = "Formato de imagen no permitido.";
        else {
            $nombreArchivoFinal = 'game_' . time() . '.' . $ext;
            $destino = __DIR__ . "/../../resources/" . $nombreArchivoFinal;
            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $destino)) {
                $errores[] = "Error al guardar la imagen. Revisa permisos de carpeta.";
            }
        }
    }

    if (!$errores) {
        conexion::exec(
            "INSERT INTO juegos (nombre, descripcion, imagen, creado_en) 
            VALUES (:nombre, :descripcion, :imagen, NOW())",
            [':nombre'=>$nombre, ':descripcion'=>$descripcion, ':imagen'=>$nombreArchivoFinal]
        );
        $exito = "Juego registrado correctamente 🎉";
    }
}
?>

<h2 style="color:white;text-align:center;margin-top:20px">Registrar Juego</h2>

<?php if ($exito): ?>
    <div style="background:#d4edda;color:#155724;padding:10px;margin:15px auto;width:60%;border-radius:5px;">
        <?= htmlspecialchars($exito) ?>
    </div>
<?php endif; ?>

<?php if ($errores): ?>
    <div style="background:#f8d7da;color:#721c24;padding:10px;margin:15px auto;width:60%;border-radius:5px;">
        <ul>
            <?php foreach($errores as $e): ?>
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

    <button type="submit" style="background:green;color:#fff;padding:10px 20px;border:none;border-radius:5px;cursor:pointer">
        Guardar
    </button>
</form>
