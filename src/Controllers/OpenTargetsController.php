<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class OpenTargetsController {
    public function procesarBusqueda() {
        $dataType = $_POST['data-type']; // 'snp', 'name', etc.
        $value = $_POST['value'];
        
        $baseUrl = "https://api.platform.opentargets.org/api/v4/public/";
        $endpoint = "association/filter?disease=EFO_0000270"; // Ejemplo

        $client = new Client(['base_uri' => $baseUrl]);
        $responseData = ['data' => null, 'error' => null];

        try {
            $response = $client->request('GET', $endpoint);
            $body = $response->getBody()->getContents();
            $responseData['data'] = json_decode($body, true);

        } catch (RequestException $e) {
            $responseData['error'] = "Error al contactar la API de Open Targets: " . $e->getMessage();
        }

        return $responseData;
    }
}