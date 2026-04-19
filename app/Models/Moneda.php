<?php

require_once __DIR__ . '/../Core/Database.php';

class Moneda
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /* ========= LISTAR TODAS LAS MONEDAS ========= */
    public function listar()
    {
        $sql = "SELECT * FROM monedas ORDER BY nombre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /* ========= OBTENER MONEDA POR ID ========= */
    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM monedas WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}
