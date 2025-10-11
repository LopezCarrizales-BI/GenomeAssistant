<?php
try {
    $conn = new PDO("mysql:host=127.0.0.1;dbname=snp_genomics", "root", "TuContraseñaAquí");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage();
}
?>
