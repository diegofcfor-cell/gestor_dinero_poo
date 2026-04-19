<?php

require_once __DIR__ . '/../Core/Database.php';

class Movimiento
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    /* ========= GUARDAR MOVIMIENTO ========= */
    public function guardar($usuario_id, $tipo, $monto, $descripcion, $categoria_id, $moneda_id = 1)
    {
        $sql = "INSERT INTO movimientos
                (usuario_id, tipo, monto, descripcion, categoria_id, moneda_id, fecha)
                VALUES
                (:usuario_id, :tipo, :monto, :descripcion, :categoria_id, :moneda_id, NOW())";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':usuario_id'   => $usuario_id,
            ':tipo'         => $tipo,
            ':monto'        => $monto,
            ':descripcion'  => $descripcion,
            ':categoria_id' => $categoria_id,
            ':moneda_id'    => $moneda_id
        ]);
    }

    /* ========= ELIMINAR MOVIMIENTO ========= */
    public function eliminar($id, $usuario_id)
    {
        // Solo permitir eliminar movimientos del usuario autenticado
        $sql = "DELETE FROM movimientos 
                WHERE id = :id AND usuario_id = :usuario_id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':usuario_id' => $usuario_id
        ]);
    }

    /* ========= LISTAR MOVIMIENTOS (CON FILTROS) ========= */
    public function listarPorUsuario($usuario_id, $desde = null, $hasta = null, $tipo = null, $categoria_id = null)
    {
        $sql = "SELECT
                    m.id,
                    m.fecha,
                    m.tipo,
                    m.monto,
                    m.descripcion,
                    c.nombre AS categoria,
                    mo.simbolo,
                    mo.nombre AS moneda,
                    mo.codigo AS codigo_moneda
                FROM movimientos m
                LEFT JOIN categorias c ON m.categoria_id = c.id
                LEFT JOIN monedas mo ON m.moneda_id = mo.id
                WHERE m.usuario_id = :usuario_id";

        $params = [':usuario_id' => $usuario_id];

        if (!empty($desde)) {
            $sql .= " AND m.fecha >= :desde";
            $params[':desde'] = $desde;
        }

        if (!empty($hasta)) {
            $sql .= " AND m.fecha <= :hasta";
            $params[':hasta'] = $hasta;
        }

        if (!empty($tipo)) {
            $sql .= " AND m.tipo = :tipo";
            $params[':tipo'] = $tipo;
        }

        if (!empty($categoria_id)) {
            $sql .= " AND m.categoria_id = :categoria_id";
            $params[':categoria_id'] = $categoria_id;
        }

        $sql .= " ORDER BY m.fecha DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll();
    }

    /* ========= TOTALES FILTRADOS ========= */
    public function totalesFiltrados($usuario_id, $desde = null, $hasta = null, $tipo = null, $categoria_id = null)
    {
        $sql = "SELECT
                    SUM(CASE WHEN tipo = 'ingreso' THEN monto ELSE 0 END) AS ingresos,
                    SUM(CASE WHEN tipo = 'egreso' THEN monto ELSE 0 END) AS egresos
                FROM movimientos
                WHERE usuario_id = :usuario_id";

        $params = [':usuario_id' => $usuario_id];

        if (!empty($desde)) {
            $sql .= " AND fecha >= :desde";
            $params[':desde'] = $desde;
        }

        if (!empty($hasta)) {
            $sql .= " AND fecha <= :hasta";
            $params[':hasta'] = $hasta;
        }

        if (!empty($tipo)) {
            $sql .= " AND tipo = :tipo";
            $params[':tipo'] = $tipo;
        }

        if (!empty($categoria_id)) {
            $sql .= " AND categoria_id = :categoria_id";
            $params[':categoria_id'] = $categoria_id;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetch();
    }

    /* ========= EGRESOS POR CATEGORÍA (GRÁFICOS) ========= */
    public function egresosPorCategoria($usuario_id)
    {
        $sql = "SELECT
                    c.nombre AS categoria,
                    SUM(m.monto) AS total
                FROM movimientos m
                JOIN categorias c ON m.categoria_id = c.id
                WHERE m.usuario_id = :usuario_id
                  AND m.tipo = 'egreso'
                GROUP BY c.nombre
                ORDER BY total DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);

        return $stmt->fetchAll();
    }
}
