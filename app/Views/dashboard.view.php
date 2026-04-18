<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="container">

<header style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
    <div>
        <h1 style="margin:0;">Gestor de Dinero</h1>
        <small>Panel principal</small>
    </div>

    <div>
        Usuario: <strong><?php echo htmlspecialchars($usuario); ?></strong> |
        <a href="index.php?controller=login&action=logout">Cerrar sesión</a>
    </div>
</header>

<p>Bienvenido <?php echo htmlspecialchars($usuario); ?></p>

<h2>Resumen</h2>

<div class="resumen">
    <div class="tarjeta ingresos">
        Ingresos
        <span>$<?php echo number_format($totalIngresos, 2); ?></span>
    </div>

    <div class="tarjeta egresos">
        Egresos
        <span>$<?php echo number_format($totalEgresos, 2); ?></span>
    </div>

    <div class="tarjeta saldo">
        Saldo
        <span>$<?php echo number_format($saldo, 2); ?></span>
    </div>
</div>

<hr>

<h2>Egresos por categoría</h2>

<div class="grafico-container">
    <canvas id="graficoEgresos"></canvas>
</div>

<hr>



<h2>Nuevo movimiento</h2>

<form method="post" action="index.php?controller=movimiento&action=guardar">

    <label>Tipo</label>
    <select name="tipo" required>
        <option value="ingreso">Ingreso</option>
        <option value="egreso">Egreso</option>
    </select>

    <label>Categoría</label>
    <select name="categoria_id" required>
        <?php foreach ($categorias as $c): ?>
            <option value="<?php echo $c['id']; ?>">
                <?php echo htmlspecialchars($c['nombre']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Monto</label>
    <input type="number" name="monto" step="0.01" required>

    <label>Descripción</label>
    <input type="text" name="descripcion">

    <button type="submit">Guardar</button>
</form>

<hr>

<h2>Filtros</h2>

<form method="get" action="index.php" style="margin-bottom:20px;">

    <input type="hidden" name="controller" value="dashboard">

    <label>Desde</label>
    <input type="date" name="desde" value="<?php echo $_GET['desde'] ?? ''; ?>">

    <label>Hasta</label>
    <input type="date" name="hasta" value="<?php echo $_GET['hasta'] ?? ''; ?>">

    <label>Tipo</label>
    <select name="tipo">
        <option value="">Todos</option>
        <option value="ingreso" <?php echo (($_GET['tipo'] ?? '') === 'ingreso') ? 'selected' : ''; ?>>Ingreso</option>
        <option value="egreso" <?php echo (($_GET['tipo'] ?? '') === 'egreso') ? 'selected' : ''; ?>>Egreso</option>
    </select>

    <label>Categoría</label>
    <select name="categoria_id">
        <option value="">Todas</option>
        <?php foreach ($categorias as $c): ?>
            <option value="<?php echo $c['id']; ?>"
                <?php echo (($_GET['categoria_id'] ?? '') == $c['id']) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($c['nombre']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Filtrar</button>
    <button type="button" onclick="window.print()">
        🖨️ Imprimir
    </button>
</form>

<hr>

<h2>Movimientos</h2>

<table>
    <tr>
        <th>Fecha</th>
        <th>Tipo</th>
        <th>Categoría</th>
        <th>Monto</th>
        <th>Descripción</th>
    </tr>

<?php if (!empty($movimientos)) : ?>
    <?php foreach ($movimientos as $m) : ?>
        <tr class="<?php echo $m['tipo']; ?>">
            <td><?php echo $m['fecha']; ?></td>
            <td><?php echo ucfirst($m['tipo']); ?></td>
            <td><?php echo htmlspecialchars($m['categoria'] ?? '-'); ?></td>
            <td class="monto">$<?php echo number_format($m['monto'], 2); ?></td>
            <td><?php echo htmlspecialchars($m['descripcion']); ?></td>
        </tr>
    <?php endforeach; ?>
<?php else : ?>
    <tr>
        <td colspan="5" style="text-align:center; padding:20px; color:#777;">
            Todavía no hay movimientos registrados.<br>
            Usá el formulario de arriba para agregar el primero.
        </td>
    </tr>
<?php endif; ?>

</table>

<p style="margin-top:30px;">
    <a href="index.php?controller=login&action=logout">🔒 Cerrar sesión</a>
</p>

</div>

<script>
const canvas = document.getElementById('graficoEgresos');

if (canvas) {
    const data = {
        labels: <?php echo json_encode($labelsCategorias); ?>,
        datasets: [{
            label: 'Egresos',
            data: <?php echo json_encode($valoresCategorias); ?>,
            backgroundColor: [
                '#e74c3c',
                '#f39c12',
                '#9b59b6',
                '#3498db',
                '#1abc9c',
                '#2ecc71',
                '#16a085'
            ]
        }]
    };

    new Chart(canvas, {
        type: 'pie',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false, // ✅ CLAVE (PASO 12.4.3)
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}
</script>

</body>
</html>
