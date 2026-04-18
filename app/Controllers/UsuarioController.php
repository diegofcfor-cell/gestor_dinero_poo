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

    /* ========= REGISTRO DE NUEVOS USUARIOS ========= */
    public function register()
    {
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario              = trim($_POST['usuario'] ?? '');
            $password             = $_POST['password'] ?? '';
            $password_confirm     = $_POST['password_confirm'] ?? '';

            // Validaciones
            if (empty($usuario)) {
                $error = "El usuario no puede estar vacío";
            } elseif (strlen($usuario) < 3) {
                $error = "El usuario debe tener al menos 3 caracteres";
            } elseif (strlen($password) < 4) {
                $error = "La contraseña debe tener al menos 4 caracteres";
            } elseif ($password !== $password_confirm) {
                $error = "Las contraseñas no coinciden";
            } else {
                // Verificar si el usuario ya existe
                $usuarioModel = new Usuario();
                if ($usuarioModel->usuarioExiste($usuario)) {
                    $error = "El usuario ya está registrado";
                } else {
                    // Crear nuevo usuario
                    if ($usuarioModel->crear($usuario, $password)) {
                        $success = "¡Registro exitoso! Redirigiendo al login...";
                        header("refresh:2;url=index.php?controller=login");
                    } else {
                        $error = "Error al registrar el usuario. Intenta de nuevo.";
                    }
                }
            }
        }

        require __DIR__ . '/../Views/registro.view.php';
    }
}
