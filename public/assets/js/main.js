import { classifyInput } from "./utils.js";

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("search-form");
  const input = document.getElementById("input");
  const resultsContainer = document.getElementById("results-container");

  form.addEventListener("submit", async (event) => {
    event.preventDefault();

    const searchTerm = input.value;
    const inputType = classifyInput(searchTerm);

    if (inputType === "unknown") {
      resultsContainer.innerHTML = `<p style="color: red;">Formato de entrada no reconocido.</p>`;
      return;
    }

    resultsContainer.innerHTML = `<p>Buscando ${searchTerm} (tipo: ${inputType})...</p>`;

    try {
      const response = await fetch("/api/search.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          term: searchTerm,
          type: inputType,
        }),
      });

      if (!response.ok) {
        throw new Error(`Error del servidor: ${response.status}`);
      }

      const data = await response.json();
      
      resultsContainer.innerHTML = `
        <pre class="salida">${JSON.stringify(data, null, 2)}</pre>
      `;
    } catch (error) {
      console.error("Error al buscar:", error);
      resultsContainer.innerHTML = `<p style="color: red;">Error: ${error.message}</p>`;
    }

    const removeElement = document.getElementById("results-pre");
    removeElement.remove();
  });
});
