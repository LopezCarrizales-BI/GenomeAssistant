<?php

class ApiLog
{
    private $conn;
    private $table = 'api_logs';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function log($endpoint, $http_code, $tiempo, $error = null)
    {
        $query = "INSERT INTO " . $this->table . " 
                  (endpoint, http_code, tiempo_respuesta_ms, mensaje_error) 
                  VALUES (:url, :code, :time, :msg)";

        try {
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':url', $endpoint);
            $stmt->bindParam(':code', $http_code);
            $stmt->bindParam(':time', $tiempo);
            $stmt->bindParam(':msg', $error);

            $stmt->execute();
        } catch (PDOException $e) {
            error_log("Fallo crítico al guardar log de API: " . $e->getMessage());
        }
    }
}
