<?php

require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../Core/Session.php';

class LoginController
{
    public function index()
    {
        require __DIR__ . '/../Views/login.view.php';
    }

    public function login()
    {
        $usuario  = $_POST['usuario'] ?? '';
        $password = $_POST['password'] ?? '';

        $usuarioModel = new Usuario();
        $user = $usuarioModel->login($usuario, $password);

        if ($user) {
            Session::set('usuario_id', $user['id']);
            Session::set('usuario', $user['usuario']);
            header("Location: index.php?controller=dashboard");
            exit;
        }

        $error = "Usuario o contraseña incorrectos";
        require __DIR__ . '/../Views/login.view.php';
    }

    public function logout()
    {
        Session::destroy();
        header("Location: index.php");
        exit;
    }
}

