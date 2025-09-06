<?php
require_once '../library/motor.php';
Plantilla::aplicar(); 

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../web/login.php"); 
    exit;
}

// Guardar el id de sesión en una variable
$usuarioid = $_SESSION['usuario_id'];

// Obtener el rol del usuario actual
$sql = "SELECT rol FROM usuarios WHERE id = :usuarioid";
$resultado = conexion::consulta($sql, [':usuarioid' => $usuarioid]);

// Como la consulta devuelve un array, tomamos el primer resultado
$rol = $resultado[0]->rol ?? 'U';  
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
        <a class="btn btn-primary" href="games_admin.php">Registrar juego</a>
    <?php endif; ?>
    <div class="grid">
        <div class="game-item">
            <a href="https://soreweb.com/web/undertale.php">
                <img src="../resources/jinxy.jpg" alt="Undertale">
            </a>
        </div>
        <div class="game-item">
            <a href="https://soreweb.com/web/deltarune.php">
                <img src="../resources/jinxy.jpg" alt="Undertale">
            </a>
        </div>
        <div class="game-item">
            <a href="https://soreweb.com/web/sans.php">
                <img src="../resources/jinxy.jpg" alt="Undertale">
            </a>
        </div>
         <div class="game-item">
            <a href="https://soreweb.com/web/sans.php">
                <img src="../resources/jinxy.jpg" alt="Undertale">
            </a>
        </div>
         <div class="game-item">
            <a href="https://soreweb.com/web/sans.php">
                <img src="../resources/jinxy.jpg" alt="Undertale">
            </a>
        </div>
           <div class="game-item">
            <a href="https://soreweb.com/web/deltarune.php">
                <img src="../resources/jinxy.jpg" alt="Undertale">
            </a>
        </div>
           <div class="game-item">
            <a href="https://soreweb.com/web/deltarune.php">
                <img src="../resources/jinxy.jpg" alt="Undertale">
            </a>
        </div>
           <div class="game-item">
            <a href="https://soreweb.com/web/deltarune.php">
                <img src="../resources/jinxy.jpg" alt="Undertale">
            </a>
        </div>
           <div class="game-item">
            <a href="https://soreweb.com/web/deltarune.php">
                <img src="../resources/jinxy.jpg" alt="Undertale">
            </a>
        </div>
           <div class="game-item">
            <a href="https://soreweb.com/web/deltarune.php">
                <img src="../resources/jinxy.jpg" alt="Undertale">
            </a>
        </div>
           <div class="game-item">
            <a href="https://soreweb.com/web/deltarune.php">
                <img src="../resources/jinxy.jpg" alt="Undertale">
            </a>
        </div>
           <div class="game-item">
            <a href="https://soreweb.com/web/deltarune.php">
                <img src="../resources/jinxy.jpg" alt="Undertale">
            </a>
        </div>
        
    </div>


</body>
