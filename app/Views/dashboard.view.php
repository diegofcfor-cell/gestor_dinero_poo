<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="dashboard-wrapper">
    <!-- Fondo animado -->
    <div class="dashboard-bg">
        <div class="money-item">💰</div>
        <div class="money-item">💵</div>
        <div class="money-item">💴</div>
        <div class="money-item">💶</div>
        <div class="money-item">💷</div>
        <div class="money-item">💳</div>
        <div class="money-item">🏦</div>
        <div class="money-item">💸</div>
    </div>

    <div class="dashboard-container">
        
        <div class="dashboard-header">
            <div>
                <h1>Gestor de Dinero</h1>
                <small>Panel principal</small>
            </div>
            <div class="dashboard-user">
                <p class="username">
                    <span class="user-avatar">😊</span>
                    <?php echo htmlspecialchars($usuario); ?>
                </p>
                <a href="index.php?controller=login&action=logout" class="logout-link">🔒 Cerrar sesión</a>
            </div>
        </div>

        <div class="dashboard-content">

            <h2 style="margin-top: 0;">Bienvenido <?php echo htmlspecialchars($usuario); ?></h2>

            <!-- RESUMEN -->
            <div class="dashboard-section">
                <h3><span class="icon">📊</span>Resumen</h3>
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
            </div>

            <!-- GRÁFICO -->
            <div class="dashboard-section grafico-section">
                <h3><span class="icon">📈</span>Egresos por categoría</h3>
                <div class="grafico-container">
                    <canvas id="graficoEgresos"></canvas>
                </div>
            </div>

            <!-- DOS COLUMNAS: NUEVO MOVIMIENTO Y FILTROS -->
            <div class="two-column-section">
                
                <!-- NUEVO MOVIMIENTO -->
                <div class="dashboard-section">
                    <h3><span class="icon">➕</span>Nuevo movimiento</h3>
                    <form method="post" action="index.php?controller=movimiento&action=guardar">

                        <label>Tipo</label>
                        <select name="tipo" required>
                            <option value="ingreso">💰 Ingreso</option>
                            <option value="egreso">💸 Egreso</option>
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
                        <input type="number" name="monto" step="0.01" required placeholder="0.00">

                        <label>Descripción</label>
                        <input type="text" name="descripcion" placeholder="Describe...">

                        <button type="submit">💾 Guardar</button>
                    </form>
                </div>

                <!-- FILTROS -->
                <div class="dashboard-section">
                    <h3><span class="icon">🔍</span>Filtros</h3>
                    <form method="get" action="index.php">

                        <input type="hidden" name="controller" value="dashboard">

                        <label>Desde</label>
                        <input type="date" name="desde" value="<?php echo $_GET['desde'] ?? ''; ?>">

                        <label>Hasta</label>
                        <input type="date" name="hasta" value="<?php echo $_GET['hasta'] ?? ''; ?>">

                        <label>Tipo</label>
                        <select name="tipo">
                            <option value="">Todos</option>
                            <option value="ingreso" <?php echo (($_GET['tipo'] ?? '') === 'ingreso') ? 'selected' : ''; ?>>Ingresos</option>
                            <option value="egreso" <?php echo (($_GET['tipo'] ?? '') === 'egreso') ? 'selected' : ''; ?>>Egresos</option>
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

                        <div class="button-group">
                            <button type="submit">🔍 Filtrar</button>
                            <button type="button" onclick="window.print()">🖨️ Imprimir</button>
                        </div>
                    </form>
                </div>

            </div>

            <!-- MOVIMIENTOS -->
            <div class="dashboard-section">
                <h3><span class="icon">📋</span>Movimientos</h3>
                <table>
                    <thead>
                        <tr>
                            <th>📅 Fecha</th>
                            <th>💱 Tipo</th>
                            <th>🏷️ Categoría</th>
                            <th>💵 Monto</th>
                            <th>📝 Descripción</th>
                            <th>⚙️ Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($movimientos)) : ?>
                        <?php foreach ($movimientos as $m) : ?>
                            <tr class="<?php echo $m['tipo']; ?>">
                                <td><?php echo $m['fecha']; ?></td>
                                <td><?php echo ($m['tipo'] === 'ingreso') ? '📈 Ingreso' : '📉 Egreso'; ?></td>
                                <td><?php echo htmlspecialchars($m['categoria'] ?? '-'); ?></td>
                                <td class="monto">$<?php echo number_format($m['monto'], 2); ?></td>
                                <td><?php echo htmlspecialchars($m['descripcion']); ?></td>
                                <td>
                                    <a href="index.php?controller=movimiento&action=eliminar&id=<?php echo $m['id']; ?>" 
                                       class="btn-eliminar" 
                                       onclick="return confirm('¿Estás seguro de que deseas eliminar este movimiento?');">
                                        🗑️ Eliminar
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" style="text-align:center; padding:20px; color:#777;">
                                Todavía no hay movimientos registrados.
                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>

<script>
const canvas = document.getElementById('graficoEgresos');

if (canvas) {
    const data = {
        labels: <?php echo json_encode($labelsCategorias); ?>,
        datasets: [{
            label: 'Egresos por Categoría',
            data: <?php echo json_encode($valoresCategorias); ?>,
            backgroundColor: [
                '#e74c3c',
                '#f39c12',
                '#9b59b6',
                '#3498db',
                '#1abc9c',
                '#2ecc71',
                '#16a085',
                '#c0392b'
            ],
            borderColor: 'rgba(255, 255, 255, 0.3)',
            borderWidth: 2
        }]
    };

    new Chart(canvas, {
        type: 'doughnut',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
}
</script>

</body>
</html>
