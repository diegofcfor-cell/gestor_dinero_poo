<?php

require_once __DIR__ . '/../Models/Movimiento.php';
require_once __DIR__ . '/../Core/Session.php';

class MovimientoController
{
    public function guardar()
    {
        // Protección de sesión
        if (!Session::has('usuario_id')) {
            header("Location: index.php");
            exit;
        }

        // Datos del formulario
        $tipo         = $_POST['tipo'] ?? '';
        $monto        = $_POST['monto'] ?? 0;
        $descripcion  = $_POST['descripcion'] ?? '';
        $categoria_id = $_POST['categoria_id'] ?? null;
        $moneda_id    = $_POST['moneda_id'] ?? 1;

        // Guardar movimiento
        if ($tipo && $monto > 0 && $categoria_id) {
            $movimiento = new Movimiento();
            $movimiento->guardar(
                Session::get('usuario_id'),
                $tipo,
                $monto,
                $descripcion,
                $categoria_id,
                $moneda_id
            );
        }

        // Volver al dashboard
        header("Location: index.php?controller=dashboard");
        exit;
    }

    /* ========= ELIMINAR MOVIMIENTO ========= */
    public function eliminar()
    {
        // Protección de sesión
        if (!Session::has('usuario_id')) {
            header("Location: index.php");
            exit;
        }

        // Obtener ID del movimiento a eliminar
        $id = $_GET['id'] ?? null;

        if ($id) {
            $movimiento = new Movimiento();
            $movimiento->eliminar($id, Session::get('usuario_id'));
        }

        // Volver al dashboard
        header("Location: index.php?controller=dashboard");
        exit;
    }
}
