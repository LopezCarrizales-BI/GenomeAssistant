<?php

class SearchHistory
{
    private $conn;
    private $table = 'historial_busquedas';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function log($usuario_id, $termino, $tipo, $encontrado = 0)
    {
        $query = "INSERT INTO " . $this->table . " 
                  (usuario_id, termino_busqueda, tipo, resultados_encontrados) 
                  VALUES (:uid, :termino, :tipo, :encontrado)";

        try {
            $stmt = $this->conn->prepare($query);

            $termino = htmlspecialchars(strip_tags($termino));
            $tipo = htmlspecialchars(strip_tags($tipo));

            $stmt->bindParam(':uid', $usuario_id);
            $stmt->bindParam(':termino', $termino);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':encontrado', $encontrado);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error guardando historial: " . $e->getMessage());
            return false;
        }
    }

    public function getTopSearches()
    {
        $query = "SELECT termino_busqueda, COUNT(*) as total 
                  FROM " . $this->table . " 
                  GROUP BY termino_busqueda 
                  ORDER BY total DESC 
                  LIMIT 5";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
