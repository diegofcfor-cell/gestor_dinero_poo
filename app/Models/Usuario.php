<?php

require_once __DIR__ . '/../Core/Database.php';

class Usuario
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function login($usuario, $password)
    {
        $sql = "SELECT id, usuario 
                FROM usuarios 
                WHERE usuario = :usuario 
                  AND password = :password";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':usuario'  => $usuario,
            ':password' => hash('sha256', $password)
        ]);

        return $stmt->fetch();
    }

    public function listar()
    {
        $sql = "SELECT id, usuario FROM usuarios ORDER BY usuario";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function crear($usuario, $password)
    {
        $usuario = trim($usuario);
        $password = trim($password);

        $stmt = $this->db->prepare(
            "INSERT INTO usuarios (usuario, password)
             VALUES (:usuario, :password)"
        );

        return $stmt->execute([
            ':usuario'  => $usuario,
            ':password' => hash('sha256', $password)
        ]);
    }


}

