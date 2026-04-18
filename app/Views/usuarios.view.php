<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Usuarios | Gestor de Dinero</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>

<div class="container">

<header style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
    <h1>Gestor de Dinero</h1>
    <a href="index.php?controller=dashboard">Volver</a>
</header>

<h2>Alta de usuario</h2>

<form method="post" action="index.php">
    <input type="hidden" name="controller" value="usuario">
    <input type="hidden" name="action" value="crear">

    <label>Usuario</label>
    <input type="text" name="usuario" required>

    <label>Contraseña</label>
    <input type="password" name="password" required>

    <button type="submit">Crear usuario</button>
</form>

<hr>

<h2>Usuarios existentes</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Usuario</th>
    </tr>

<?php foreach ($usuarios as $u): ?>
    <tr>
        <td><?php echo $u['id']; ?></td>
        <td><?php echo htmlspecialchars($u['usuario']); ?></td>
    </tr>
<?php endforeach; ?>

</table>

</div>

</body>
</html>
