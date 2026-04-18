<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Login | Gestor de Dinero</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>

<div class="login-wrapper">
    <div class="login-box">

        <h1>Gestor de Dinero</h1>
        <p>Acceso al sistema</p>

        <?php if (!empty($error)): ?>
            <div class="login-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="index.php?controller=login&action=login">

            <label>Usuario</label>
            <input type="text" name="usuario" required>

            <label>Contraseña</label>
            <input type="password" name="password" required>

            <button type="submit">Ingresar</button>

        </form>

    </div>
</div>

</body>
</html>

