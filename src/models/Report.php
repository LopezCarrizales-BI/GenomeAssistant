<?php

class Report
{
    private $conn;
    private $table = 'reportes_guardados';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function save($usuario_id, $nombre, $datos_json)
    {
        $query = "INSERT INTO " . $this->table . " 
                  (usuario_id, nombre_reporte, datos_json) 
                  VALUES (:uid, :nombre, :datos)";

        try {
            $stmt = $this->conn->prepare($query);

            $nombre = htmlspecialchars(strip_tags($nombre));

            $stmt->bindParam(':uid', $usuario_id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':datos', $datos_json);

            if ($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error guardando reporte: " . $e->getMessage());
            return false;
        }
    }

    public function getByUser($usuario_id)
    {
        $query = "SELECT id, nombre_reporte, fecha_creacion 
                  FROM " . $this->table . " 
                  WHERE usuario_id = :uid 
                  ORDER BY fecha_creacion DESC";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':uid', $usuario_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function rename($id, $newName)
    {
        $query = "UPDATE " . $this->table . " SET nombre_reporte = :name WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $name = htmlspecialchars(strip_tags($newName));

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
