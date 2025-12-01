<?php
// public/EnsemblController.php

// Asegúrate de que la ruta al modelo sea correcta según tu estructura
if (file_exists('../src/Models/ApiLog.php')) {
    require_once '../src/Models/ApiLog.php';
} elseif (file_exists('../src/models/ApiLog.php')) {
    require_once '../src/models/ApiLog.php';
}

class EnsemblController
{
    private $baseUrl = "https://rest.ensembl.org";
    private $dbConnection; // Guardaremos la conexión aquí

    // CAMBIO 1: Recibir la conexión en el constructor (Opcional, puede ser null)
    public function __construct($db = null)
    {
        $this->dbConnection = $db;
    }

    private function makeRequest($endpoint)
    {
        $startTime = microtime(true); // Iniciar cronómetro

        $ch = curl_init();
        $url = $this->baseUrl . $endpoint;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch); // Capturar error de red si hay
        curl_close($ch);

        $endTime = microtime(true); // Detener cronómetro
        $duration = round($endTime - $startTime, 4); // Calcular duración

        // CAMBIO 2: Guardar en la base de datos (Si tenemos conexión)
        if ($this->dbConnection) {
            $logger = new ApiLog($this->dbConnection);
            // Si hubo error de cURL, lo usamos, si no, null
            $logMsg = $curlError ? "cURL Error: $curlError" : null;

            // Si la API devolvió error (400/404/500), guardamos el cuerpo de la respuesta como mensaje
            if ($httpCode >= 400 && !$logMsg) {
                $logMsg = substr(strip_tags($response), 0, 200); // Guardamos primeros 200 caracteres
            }

            $logger->log($endpoint, $httpCode, $duration, $logMsg);
        }

        // --- Manejo de Errores Normal (Igual que antes) ---
        if ($response === false) {
            throw new Exception("Error cURL: " . $curlError);
        }

        if ($httpCode !== 200) {
            $jsonError = json_decode($response, true);
            $msg = $jsonError['error'] ?? "Error desconocido (Código $httpCode)";

            if ($httpCode == 404 || $httpCode == 400) {
                return null;
            }
            throw new Exception("Error Ensembl API: " . $msg);
        }

        return json_decode($response, true);
    }

    public function search($database, $term)
    {
        $term = trim($term);
        $endpoint = "/variation/human/{$term}?content-type=application/json";

        try {
            $data = $this->makeRequest($endpoint);

            if (!$data) {
                return [];
            }
            return [$this->processSingleResult($data)];
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function processSingleResult($item)
    {
        $variantId = $item['name'] ?? 'N/A';
        $chrPos = "N/A";
        if (isset($item['mappings'])) {
            foreach ($item['mappings'] as $mapping) {
                if (isset($mapping['assembly_name']) && $mapping['assembly_name'] === 'GRCh38') {
                    $chr = $mapping['seq_region_name'] ?? '?';
                    $start = $mapping['start'] ?? '?';
                    $chrPos = "Chr {$chr}:{$start}";
                    break;
                }
            }
        }

        $alleles = "N/A";
        if (isset($item['mappings'][0]['allele_string'])) {
            $alleles = str_replace('/', '>', $item['mappings'][0]['allele_string']);
        }

        $gene = "Ver detalle*";
        $frequency = "N/A";
        if (isset($item['MAF']) && $item['MAF'] !== null) {
            $frequency = $item['MAF'];
        }

        return [
            'variant_id' => $variantId,
            'chr_pos'    => $chrPos,
            'gene'       => $gene,
            'alleles'    => $alleles,
            'frequency'  => $frequency
        ];
    }
}
