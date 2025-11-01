<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->load();

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['error' => 'No input received']);
    exit;
}

$term = $input['term'] ?? null;
$type = $input['type'] ?? null;

if (!$term || !$type) {
    echo json_encode(['error' => 'Faltan término (term) o tipo (type)']);
    exit;
}

function fetchNcbiSummary($db, $searchTerm)
{
    $baseUrl = 'https://eutils.ncbi.nlm.nih.gov/entrez/eutils/';

    $apiKey = getenv('NCBI_API_KEY');
    $keyParam = $apiKey ? "&api_key={$apiKey}" : '';

    $encodedTerm = urlencode($searchTerm);
    $searchUrl = "{$baseUrl}esearch.fcgi?db={$db}&term={$encodedTerm}&retmode=json{$keyParam}";

    $searchJson = @file_get_contents($searchUrl);
    if ($searchJson === false) {
        return ['error' => 'Error en ESearch al contactar NCBI'];
    }
    $searchData = json_decode($searchJson, true);

    $uidList = $searchData['esearchresult']['idlist'] ?? [];
    if (empty($uidList)) {
        return ['error' => 'No results found'];
    }
    $uid = $uidList[0];

    $summaryUrl = "{$baseUrl}esummary.fcgi?db={$db}&id={$uid}&retmode=json{$keyParam}";

    $summaryJson = @file_get_contents($summaryUrl);
    if ($summaryJson === false) {
        return ['error' => 'Error en ESummary al contactar NCBI'];
    }
    $summaryData = json_decode($summaryJson, true);

    return $summaryData['result'][$uid] ?? ['error' => 'Resultado inesperado de ESummary'];
}

$db = '';
$searchTerm = '';

switch ($type) {
    case 'snp':
        $db = 'snp';
        $searchTerm = $term;
        break;

    case 'gene':
        $db = 'gene';
        $searchTerm = "{$term}[Gene Name]";
        break;

    case 'coords':
        $db = 'snp';
        $parts = explode(':', $term);
        if (count($parts) === 2) {
            $searchTerm = "{$parts[0]}[CHR] AND {$parts[1]}[POS]";
        }
        break;

    case 'hgvs':
        $db = 'clinvar';
        $searchTerm = $term;
        break;

    default:
        echo json_encode(['error' => 'Tipo de búsqueda no soportado']);
        exit;
}

if (empty($searchTerm)) {
    echo json_encode(['error' => 'Término de búsqueda inválido para el tipo dado']);
    exit;
}

$data = fetchNcbiSummary($db, $searchTerm);
echo json_encode($data);
