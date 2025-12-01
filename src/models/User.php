<?php

class User
{
    private $conn;
    private $table = 'usuarios';

    public $id;
    public $nombre_completo;
    public $email;
    public $password;
    public $rol_id;
    public $activo;
    public $fecha_registro;
    public $institucion;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $query = "SELECT u.*, r.nombre as rol_nombre 
                  FROM " . $this->table . " u
                  LEFT JOIN roles r ON u.rol_id = r.id
                  ORDER BY u.fecha_registro DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table . " 
                  (nombre_completo, email, password, rol_id, activo, institucion, fecha_registro) 
                  VALUES (:nombre, :email, :password, :rol, :activo, :inst, NOW())";

        $stmt = $this->conn->prepare($query);

        $this->nombre_completo = htmlspecialchars(strip_tags($this->nombre_completo));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->institucion = htmlspecialchars(strip_tags($this->institucion));

        $hash = password_hash($this->password, PASSWORD_DEFAULT);

        $stmt->bindParam(':nombre', $this->nombre_completo);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $hash);
        $stmt->bindParam(':rol', $this->rol_id);
        $stmt->bindParam(':activo', $this->activo);
        $stmt->bindParam(':inst', $this->institucion);

        return $stmt->execute();
    }

    public function update($id, $data)
    {
        $query = "UPDATE " . $this->table . " 
                  SET nombre_completo = :nombre, 
                      email = :email, 
                      rol_id = :rol, 
                      activo = :activo,
                      institucion = :inst";

        if (!empty($data['password'])) {
            $query .= ", password = :password";
        }

        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':rol', $data['rol']);
        $stmt->bindParam(':activo', $data['activo']);
        $stmt->bindParam(':inst', $data['institucion']);
        $stmt->bindParam(':id', $id);

        if (!empty($data['password'])) {
            $hash = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hash);
        }

        return $stmt->execute();
    }
}
