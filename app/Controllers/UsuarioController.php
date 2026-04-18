<?php

require_once __DIR__ . '/../Core/Session.php';
require_once __DIR__ . '/../Models/Usuario.php';

class UsuarioController
{
    public function index()
    {
        if (!Session::has('usuario_id')) {
            header("Location: index.php");
            exit;
        }

        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->listar();

        require __DIR__ . '/../Views/usuarios.view.php';
    }

    public function crear()
    {
        if (!Session::has('usuario_id')) {
            header("Location: index.php");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario  = $_POST['usuario'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($usuario !== '' && $password !== '') {
                $usuarioModel = new Usuario();
                $usuarioModel->crear($usuario, $password);
            }
        }

        header("Location: index.php?controller=usuario");
        exit;
    }


}
