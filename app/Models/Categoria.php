<?php

require_once __DIR__ . '/../Core/Database.php';

class Categoria
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Listar todas las categorías
     */
    public function listar()
    {
        $sql = "SELECT id, nombre, tipo
                FROM categorias
                ORDER BY nombre";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
