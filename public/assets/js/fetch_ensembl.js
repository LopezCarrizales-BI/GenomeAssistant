async function getEnsemblData(ensemblID) {
  const url = `https://rest.ensembl.org/lookup/id/${ensemblID}`;

  try {
    const response = await fetch(url, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (!response.ok) {
      throw new Error(`Error HTTP: ${response.status} ${response.statusText}`);
    }

    const data = await response.json();

    console.log("Datos recibidos:", data);
    console.log(`Nombre: ${data.display_name}`);
    console.log(`Especie: ${data.species}`);
    console.log(`ID: ${data.id}`);

    return data;
  } catch (error) {
    console.error("Error al consultar la API de Ensembl:", error);
  }
}
