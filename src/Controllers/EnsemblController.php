<?php

class EnsemblController
{
    /**
     * Procesa los datos del formulario, llama a Perl y DEVUELVE los resultados.
     * @return array Un array con los datos o un mensaje de error.
     */
    public function procesarBusqueda()
    {
        // Inicializamos las variables de respuesta
        $responseData = [
            'data' => null,
            'error' => null,
            'userInput' => [] // Para recordar lo que el usuario buscó
        ];

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['data-type']) || empty($_POST['value'])) {
            $responseData['error'] = "Acceso inválido o datos incompletos.";
            return $responseData;
        }

        $dataType = $_POST['data-type'];
        $value = $_POST['value'];
        
        $responseData['userInput'] = ['data-type' => $dataType, 'value' => $value];

        $scriptPath = '../services/perl/scripts/fetch_ensembl_data.pl';
        $safeDataType = escapeshellarg($dataType);
        $safeValue = escapeshellarg($value);
        $command = "C:\Strawberry\perl\bin\perl.exe " . $scriptPath . " " . $safeDataType . " " . $safeValue . " 2>&1";
        
        $jsonOutput = shell_exec($command);
        $data = json_decode($jsonOutput, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            $responseData['data'] = $data;
        } else {
            $responseData['error'] = "Error del servicio: " . htmlspecialchars($jsonOutput);
        }

        return $responseData;
    }
}
?>