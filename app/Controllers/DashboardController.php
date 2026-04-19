<?php

require_once __DIR__ . '/../Core/Session.php';
require_once __DIR__ . '/../Models/Movimiento.php';
require_once __DIR__ . '/../Models/Categoria.php';
require_once __DIR__ . '/../Models/Moneda.php';

class DashboardController
{
    public function index()
    {
        // 🔐 Protección de sesión
        if (!Session::has('usuario_id')) {
            header("Location: index.php");
            exit;
        }

        // 👤 Datos del usuario
        $usuario_id = Session::get('usuario_id');
        $usuario    = Session::get('usuario');

        // 📦 Modelos
        $movimientoModel = new Movimiento();
        $categoriaModel  = new Categoria();
        $monedaModel     = new Moneda();

        // 💰 Movimientos y totales
        $movimientos = $movimientoModel->listarPorUsuario(
            $usuario_id,
            $_GET['desde'] ?? null,
            $_GET['hasta'] ?? null,
            $_GET['tipo'] ?? null,
            $_GET['categoria_id'] ?? null
        );

        $totales = $movimientoModel->totalesFiltrados(
            $usuario_id,
            $_GET['desde'] ?? null,
            $_GET['hasta'] ?? null,
            $_GET['tipo'] ?? null,
            $_GET['categoria_id'] ?? null
        );

        $totalIngresos = $totales['ingresos'] ?? 0;
        $totalEgresos  = $totales['egresos'] ?? 0;
        $saldo         = $totalIngresos - $totalEgresos;


        // 🗂️ Categorías
        $categorias = $categoriaModel->listar();

        // 💱 Monedas
        $monedas = $monedaModel->listar();

        // 🛡️ Blindaje (evita errores fatales en la vista)
        $movimientos   = $movimientos   ?? [];
        $categorias    = $categorias    ?? [];
        $monedas       = $monedas       ?? [];
        $totalIngresos = $totalIngresos ?? 0;
        $totalEgresos  = $totalEgresos  ?? 0;
        $saldo         = $saldo         ?? 0;

        // 🎨 Render de la vista
        // 📊 Datos para gráfico de egresos por categoría
        $egresosPorCategoria = $movimientoModel->egresosPorCategoria($usuario_id);

        // Preparar arrays simples para JS
        $labelsCategorias = [];
        $valoresCategorias = [];

        foreach ($egresosPorCategoria as $fila) {
            $labelsCategorias[]  = $fila['categoria'];
            $valoresCategorias[] = (float) $fila['total'];
        }

        require __DIR__ . '/../Views/dashboard.view.php';
    }
}
