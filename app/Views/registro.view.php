<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registro | Gestor de Dinero</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>
<body>

<div class="login-wrapper">
    <div class="login-box">

        <h1>Gestor de Dinero</h1>
        <p>Crear nueva cuenta</p>

        <?php if (!empty($error)): ?>
            <div class="login-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="login-success">
                ✓ <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="index.php?controller=usuario&action=register">

            <label>Usuario</label>
            <input type="text" name="usuario" minlength="3" maxlength="50" required>
            <small>Mínimo 3 caracteres</small>

            <label>Contraseña</label>
            <input type="password" name="password" minlength="4" maxlength="100" required>
            <small>Mínimo 4 caracteres</small>

            <label>Confirmar contraseña</label>
            <input type="password" name="password_confirm" minlength="4" maxlength="100" required>

            <button type="submit">Registrarse</button>

        </form>

        <div class="login-footer">
            <p>¿Ya tienes cuenta? <a href="index.php?controller=login" class="registro-link">Inicia sesión aquí</a></p>
        </div>

    </div>
</div>

</body>
</html>
