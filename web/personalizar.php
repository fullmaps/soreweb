<?php
require_once '../library/motor.php';
session_start();

// Validar sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../web/login.php");
    exit;
}

$usuarioid = $_SESSION['usuario_id'];

// Validar ID en URL (usuario_id)
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de usuario no válido.";
    exit;
}

$idUsuarioPerfil = (int)$_GET['id'];

// Solo puedes personalizar tu propio perfil
if ($usuarioid !== $idUsuarioPerfil) {
    echo "No tienes permiso para editar este perfil.";
    exit;
}

// Buscar perfil existente o crear uno vacío si no existe
$sql = "SELECT * FROM perfil WHERE usuario_id = ?";
$resultado = conexion::consulta($sql, [$idUsuarioPerfil]);
$perfil = (count($resultado) > 0) ? $resultado[0] : null;

// Guardar cambios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descripcion = $_POST['descripcion'] ?? '';
    $background = $_POST['background'] ?? '';
    $carta = $_POST['carta'] ?? '';

    // Manejo de foto (upload simple)
    $foto = $perfil ? $perfil->foto : null;
    if (!empty($_FILES['foto']['name'])) {
        $ruta = "../uploads/" . basename($_FILES['foto']['name']);
        move_uploaded_file($_FILES['foto']['tmp_name'], $ruta);
        $foto = $ruta;
    }

    if ($perfil) {
        // Update
        $sql = "UPDATE perfil 
                SET descripcion = ?, foto = ?, background = ?, carta = ? 
                WHERE usuario_id = ?";
        conexion::consulta($sql, [$descripcion, $foto, $background, $carta, $idUsuarioPerfil]);
    } else {
        // Insert
        $sql = "INSERT INTO perfil (usuario_id, descripcion, foto, background, carta) 
                VALUES (?, ?, ?, ?, ?)";
        conexion::consulta($sql, [$idUsuarioPerfil, $descripcion, $foto, $background, $carta]);
    }

    header("Location: perfil.php?id=" . $idUsuarioPerfil);
    exit;
}

Plantilla::aplicar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../design/personalizar.css">
    <script src="../js/personalizar.js" defer></script>

</head>
<body>
<section class="perfil-container">
    <h1 class="perfil-titulo">Personalizar Perfil</h1>

    <form action="" method="POST" enctype="multipart/form-data" class="perfil-card">
        <label>Nombre</label>
        <input type="text" value="<?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? ''); ?>" disabled>


        <label>Descripción</label>
        <textarea name="descripcion" value="" rows="4"><?php echo $perfil->descripcion ?? ''; ?></textarea>

        <label>Foto de perfil</label>
        <input type="file" name="foto">
        <?php if (!empty($perfil->foto)): ?>
            <img src="<?php echo $perfil->foto; ?>" alt="Foto actual" width="120">
        <?php endif; ?>

        <label>Fondo (URL)</label>
        <input type="text" name="background" value="<?php echo $perfil->background ?? ''; ?>">

        <label>Estilo de carta</label>
        <select name="carta" id="carta-select">
            <option value="">Normal</option>
            <option value="verde" <?php if (($perfil->carta ?? '') === 'verde') echo 'selected'; ?>>Verde</option>
            <option value="morado" <?php if (($perfil->carta ?? '') === 'morado') echo 'selected'; ?>>Morado</option>
            <option value="oscuro" <?php if (($perfil->carta ?? '') === 'oscuro') echo 'selected'; ?>>Oscuro</option>
        </select>

        <button type="submit" class="btn-deltarune">Guardar cambios</button>
    </form>
</section>
</body>
</html>
