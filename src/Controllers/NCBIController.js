const { error } = require("console");

/**
 * Busca un término en una base de datos de NCBI y obtiene su resumen.
 * @param {string} database - La base de datos (ej. 'snp', 'gene', 'assembly').
 * @param {string} term - El término de búsqueda (ej. 'rs7528419').
 * @param {string} apiKey - (Opcional pero recomendado) Tu clave de API de NCBI.
 */
async function getNcbiData(database, term, apiKey = null) {
  const baseUrl = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/";

  const keyParam = apiKey ? `&api_key=${apiKey}` : "";

  try {
    const searchTerm = encodeURIComponent(term);
    const searchUrl = `${baseUrl}esearch.fcgi?database=${database}&term=${searchTerm}&retmode=json${keyParam}`;

    console.log(`Buscando en: ${searchUrl}`);
    const searchResponse = await fetch(searchUrl);

    if (!searchResponse.ok) {
      throw new Error(`Error en ESearch: ${searchResponse.status}`);
    }

    const searchData = await searchResponse.json();

    const uidList = searchData.esearchresult.idlist;
    if (uidList.length === 0) {
      console.log(`No se encontraron resultados para el término: ${term}`);
      return;
    }
    const uid = uidList[0];

    const summaryUrl = `${baseUrl}esummary.fcgi?database=${database}&id=${uid}&retmode=json${keyParam}`;

    console.log(`Obteniendo resumen desde: ${summaryUrl}`);
    const summaryResponse = await fetch(summaryUrl);

    if (!summaryResponse.ok) {
      throw new Error(`Error en ESummary: ${summaryResponse.status}`);
    }

    const summaryData = await summaryResponse.json();

    const result = summaryData.result[uid];
    console.log("Datos recibidos (ESummary):", result);

    return result;
  } catch (error) {
    console.error("Error al consultar la API de NCBI:", error);
  }
}

const genericSearch = async (req, res) => {
  try {
    const { term, type } = req.body;

    if (!term || !type) {
      return res
        .status(400)
        .json({ error: "Faltan término (term) o tipo (type)." });
    }

    const apiKey = process.env.NCBI_API_KEY || null;
    let database = 'snp';
    let searchTerm;

    console.log("Servidor: Buscando");
    const data = await getNcbiSummary(database, searchTerm, apiKey);

    if (data.error) {
      return res.status(404).json(data);
    }

    res.json(data);
  } catch {
    console.error("Error en genericSearch controller: ", error);
    res.status(500).json({ error: error.message });
  }
};

module.exports = { genericSearch };
