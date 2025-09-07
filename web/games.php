<?php
require_once '../library/motor.php';
Plantilla::aplicar(); 

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../web/login.php"); 
    exit;
}

$usuarioid = $_SESSION['usuario_id'];

$sql = "SELECT rol FROM usuarios WHERE id = :usuarioid";
$resultado = conexion::consulta($sql, [':usuarioid' => $usuarioid]);

$rol = $resultado[0]->rol ?? 'U';  

$juegos = conexion::consulta("SELECT id, nombre, descripcion, imagen FROM juegos ORDER BY creado_en DESC");
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../resources/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../design/stylegames.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <title>SoreWeb</title>
</head>

<body>
    <div class="container">
        <h2>¡Bienvenido a la sección de juegos de Sore! </h2>
        <h5>Aquí encontrarás una selección de juegos emocionantes para disfrutar.</h5>
    </div>
    
  <?php if ($rol === 'A'): ?>
    <div class="btn-container" style="text-align:center;">
        <a class="btn-deltarune" href="games_admin.php">Registrar Juego</a>
    </div>
<?php endif; ?>

    
    <div class="grid">
        <?php foreach ($juegos as $juego): ?>
            <div class="game-item">
                <a href="detalle_juego.php?id=<?= $juego->id ?>">
                    <img src="../resources/<?= htmlspecialchars($juego->imagen) ?>" 
                         alt="<?= htmlspecialchars($juego->nombre) ?>">
                </a>
                <h5 style="text-align:center; color:white; margin-top:10px;">
                    <?= htmlspecialchars($juego->nombre) ?>
                </h5>
            </div>
        <?php endforeach; ?>
    </div>
</body>
