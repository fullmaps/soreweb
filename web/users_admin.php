<?php
require_once("../library/motor.php");
Plantilla::aplicar();

// Leer mensajes pasados por GET (acciones)
$msg = isset($_GET["msg"]) ? urldecode($_GET["msg"]) : "";

// Obtener usuarios actualizados
$usuarios = conexion::consulta("SELECT * FROM usuarios");
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../resources/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../design/users_manager.css">
    <title>Administración de Usuarios - SoreWeb</title>
</head>
<h1 class="panel-title">Panel de Administración</h1>

<?php if ($msg): ?>
    <div class="panel-msg"><?= $msg ?></div>
<?php endif; ?>

<div class="panel-container">
    <table class="user-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Estado</th>
                <th>Baneado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($usuarios as $u): ?>
            <tr class="<?= $u->activo ? 'fila-activo' : 'fila-inactivo' ?>">
                <td><?= $u->id ?></td>
                <td><?= htmlspecialchars($u->nombre) ?></td>
                <td><?= htmlspecialchars($u->correo) ?></td>
                <td><?= $u->activo ? "Activo ✅" : "Inactivo ⏸️" ?></td>
                <td><?= isset($u->baneado) && $u->baneado ? "Sí 🚫" : "No ✅" ?></td>
                <td>
                    <form method="post" action="acciones.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $u->id ?>">

                        <!-- Activar/Inactivar -->
                        <?php if ($u->activo): ?>
                            <button class="btn-inactivar" name="inactivar">Inactivar</button>
                        <?php else: ?>
                            <button class="btn-activar" name="activar">Activar</button>
                        <?php endif; ?>

                        <!-- Banear/Desbanear -->
                        <?php if (isset($u->baneado) && $u->baneado): ?>
                            <button class="btn-desban" name="desbanear">Desbanear</button>
                        <?php else: ?>
                            <button class="btn-ban" name="banear">Banear</button>
                        <?php endif; ?>

                        <button class="btn-reset" name="reset">Resetear</button>
                        <button class="btn-delete" name="delete" onclick="return confirm('¿Eliminar usuario?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
// Plantilla cierra sola con el destructor
?>
