<?php
require_once '../library/motor.php';
Plantilla::aplicar();

session_start();

// VERIFICAR SESIÓN
if (!isset($_GET['id'])) {
    die("Juego no especificado.");
}

$id = intval($_GET['id']);

// OBTENER DETALLES DEL JUEGO
$sql = "SELECT * FROM juegos WHERE id = :id";
$resultado = conexion::consulta($sql, [':id' => $id]);

$juego = $resultado[0] ?? null;

// VERIFICADOR DEL JUEGO
if (!$juego) {
    die("Juego no encontrado.");
}

$usuarioid = $_SESSION['usuario_id'];

// VERIFICAR ROL
$sql = "SELECT rol FROM usuarios WHERE id = :usuarioid";
$resultado = conexion::consulta($sql, [':usuarioid' => $usuarioid]);

$rol = $resultado[0]->rol ?? 'U';  
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($juego->nombre) ?> - SoreWeb</title>
    <link rel="icon" href="../resources/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../design/styledetalles.css">
</head>
<body>
    <div class="game-card">
        <?php if ($juego->imagen): ?>
            <img src="../resources/<?= htmlspecialchars($juego->imagen) ?>" alt="<?= htmlspecialchars($juego->nombre) ?>">
        <?php endif; ?>

        <div class="game-content">
            <h2><?= htmlspecialchars($juego->nombre) ?></h2>
            <p><strong>Descripción:</strong> <?= nl2br(htmlspecialchars($juego->descripcion)) ?></p>
            
            <p><strong>Horas jugadas:</strong> <?= htmlspecialchars($juego->horas) ?></p>
            <p><strong>Dificultad:</strong> <?= htmlspecialchars($juego->dificultad) ?></p>
            <p><strong>Estado:</strong> <?= htmlspecialchars($juego->estado) ?></p>
            <p><strong>Fecha de esta publicacion:</strong> <?= htmlspecialchars($juego->creado_en) ?></p>
            
            <div class="rating">
                <strong>Rating:</strong> 
                <?php if ($juego->rating_custom): ?>
                    <img src="<?= htmlspecialchars($juego->rating_custom) ?>" alt="Custom Rating">
                <?php else: ?>
                    <?php for ($i=0; $i<$juego->rating; $i++): ?>
                        ⭐
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="text-center">
        <a href="games.php" class="btn-deltarune">Volver al catálogo</a>
        <?php if ($rol === 'A'): ?>
        <a class="btn-deltarune" href="games_admin.php">Editar</a>
        <a class="btn-deltarune" href="games_admin.php">Eliminar</a>
        <?php endif; ?>

    </div>
      
        
</body>
