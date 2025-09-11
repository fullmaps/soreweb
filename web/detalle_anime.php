<?php
require_once '../library/motor.php';
Plantilla::aplicar();

session_start();

// VERIFICAR SESIÓN Y ID DEL ANIME
if (!isset($_GET['id'])) {
    die("Anime no especificado.");
}

$id = intval($_GET['id']);

// OBTENER DETALLES DEL ANIME
$sql = "SELECT * FROM animes WHERE id = :id";
$resultado = conexion::consulta($sql, [':id' => $id]);

$anime = $resultado[0] ?? null;

// VERIFICAR QUE EXISTA EL ANIME
if (!$anime) {
    die("Anime no encontrado.");
}

$usuarioid = $_SESSION['usuario_id'] ?? 0;

// VERIFICAR ROL
$sql = "SELECT rol FROM usuarios WHERE id = :usuarioid";
$resultado = conexion::consulta($sql, [':usuarioid' => $usuarioid]);

$rol = $resultado[0]->rol ?? 'U';  
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($anime->titulo) ?> - SoreWeb</title>
    <link rel="icon" href="../resources/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../design/styledetalles.css">
</head>
<body>
    <div class="game-card">
        <?php if ($anime->imagen): ?>
            <img src="../resources/<?= htmlspecialchars($anime->imagen) ?>" alt="<?= htmlspecialchars($anime->titulo) ?>">
        <?php endif; ?>

        <div class="game-content">
            <h2><?= htmlspecialchars($anime->titulo) ?></h2>
            <p><strong>Descripción:</strong> <?= nl2br(htmlspecialchars($anime->descripcion)) ?></p>
            
            <p><strong>Capítulos:</strong> <?= htmlspecialchars($anime->capitulos) ?></p>
            <p><strong>Estado:</strong> <?= htmlspecialchars($anime->estado) ?></p>
            <p><strong>Fecha de publicación:</strong> <?= htmlspecialchars($anime->creado_en) ?></p>
            
            <div class="rating">
                <strong>Rating:</strong> 
                <?php if ($anime->rating_custom): ?>
                    <?php for ($i = 0; $i < $anime->rating; $i++): ?>
                        <img src="<?= htmlspecialchars($anime->rating_custom) ?>" alt="Custom Rating" style="width:20px;height:20px;">
                    <?php endfor; ?>
                <?php else: ?>
                    <?php for ($i = 0; $i < $anime->rating; $i++): ?>
                        ⭐
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="text-center mt-3">
        <a href="animes.php" class="btn-deltarune">Volver al catálogo</a>
        <?php if ($rol === 'A'): ?>
            <a class="btn-deltarune" href="animes_admin.php?id=<?= $anime->id ?>">Editar</a>
            <a class="btn-deltarune" href="../controllers/eliminar_anime.php?id=<?= $anime->id ?>" onclick="return confirm('¿Seguro que quieres eliminar este anime?')">Eliminar</a>
        <?php endif; ?>
    </div>
</body>
