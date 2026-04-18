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

        // Guardar movimiento
        if ($tipo && $monto > 0 && $categoria_id) {
            $movimiento = new Movimiento();
            $movimiento->guardar(
                Session::get('usuario_id'),
                $tipo,
                $monto,
                $descripcion,
                $categoria_id
            );
        }

        // Volver al dashboard
        header("Location: index.php?controller=dashboard");
        exit;
    }
}
