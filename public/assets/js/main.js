document.addEventListener("DOMContentLoaded", () => {
  const searchForm = document.getElementById("search-form");
  const resultsBody = document.getElementById("results-body");
  const noResultsView = document.getElementById("no-results-view");
  const resultsTableView = document.getElementById("results-table-view");
  const searchInput = document.getElementById("input");

  const exportBtn = document.getElementById("export-btn");
  let currentSearchData = [];

  const clearBtn = document.getElementById("clear-btn");
  if (clearBtn) {
    clearBtn.addEventListener("click", (e) => {
      e.preventDefault();
      searchInput.value = "";
      resultsBody.innerHTML = "";
      resultsTableView.style.display = "none";
      noResultsView.style.display = "flex";
      searchInput.focus();
      currentSearchData = [];
    });
  }

  if (searchForm) {
    searchForm.addEventListener("submit", async (e) => {
      e.preventDefault();

      const input = searchInput.value.trim();
      if (!input) return;

      let type = "snp";
      if (input.includes(":")) {
        type = "coords";
      } else if (!input.toLowerCase().startsWith("rs") && !/\d/.test(input)) {
        type = "gene";
      }

      const btn = searchForm.querySelector("button");
      const originalText = btn.innerText;
      btn.innerText = "Searching...";
      btn.disabled = true;

      try {
        const basePath = typeof BASE_URL !== "undefined" ? BASE_URL : "";
        const endpoint = `${basePath}/api/search`;

        console.log("Enviando petición a:", endpoint);

        const response = await fetch(endpoint, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
          body: JSON.stringify({ term: input, type: type }),
        });

        const contentType = response.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
          const text = await response.text();
          throw new Error(
            "El servidor no devolvió JSON: " + text.substring(0, 50)
          );
        }

        const result = await response.json();

        if (result.success && result.data && result.data.length > 0) {
          currentSearchData = result.data;
          renderTable(result.data);
          toggleView(true);
        } else {
          toggleView(false);
          currentSearchData = [];
          if (result.error) {
            alert("Error: " + result.error);
          } else {
            alert("No se encontraron resultados.");
          }
        }
      } catch (error) {
        console.error("Error JS:", error);
        alert("Ocurrió un error: " + error.message);
      } finally {
        btn.innerText = originalText;
        btn.disabled = false;
      }
    });
  }

  if (exportBtn) {
    exportBtn.addEventListener("click", async () => {
      if (currentSearchData.length === 0) {
        alert("No hay datos para exportar. Realiza una búsqueda primero.");
        return;
      }

      const filename = prompt(
        "Ingresa un nombre para tu reporte:",
        "reporte_genome"
      );
      if (!filename) return;

      try {
        const basePath = typeof BASE_URL !== "undefined" ? BASE_URL : "";
        const saveEndpoint = `${basePath}/api/report/save`;

        const response = await fetch(saveEndpoint, {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            nombre: filename,
            data: currentSearchData,
          }),
        });

        const saveResult = await response.json();
        if (!saveResult.success) {
          console.warn("No se pudo guardar en BD:", saveResult.error);
        } else {
          console.log("Reporte guardado en BD correctamente.");
        }
      } catch (err) {
        console.error("Error al guardar en BD:", err);
      }

      downloadCSV(currentSearchData, filename);
    });
  }

  function toggleView(hasResults) {
    if (hasResults) {
      noResultsView.style.display = "none";
      resultsTableView.style.display = "block";
    } else {
      noResultsView.style.display = "flex";
      resultsTableView.style.display = "none";
    }
  }

  function renderTable(data) {
    resultsBody.innerHTML = "";
    data.forEach((row) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
                <td>${row.variant_id}</td>
                <td>${row.chr_pos}</td>
                <td>
                    <span style="background-color: #e0f2fe; color: #0284c7; padding: 2px 8px; border-radius: 4px; font-weight: 600;">
                        ${row.gene}
                    </span>
                </td>
                <td>${row.alleles}</td> 
                <td>${row.frequency}</td>
            `;
      resultsBody.appendChild(tr);
    });
  }

  function downloadCSV(data, filename) {
    const csvRows = [];
    const headers = Object.keys(data[0]);
    csvRows.push(headers.join(","));

    for (const row of data) {
      const values = headers.map((header) => {
        const escaped = ("" + row[header]).replace(/"/g, '\\"');
        return `"${escaped}"`;
      });
      csvRows.push(values.join(","));
    }

    const csvString = csvRows.join("\n");
    const blob = new Blob([csvString], { type: "text/csv" });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.setAttribute("hidden", "");
    a.setAttribute("href", url);
    a.setAttribute("download", filename + ".csv");
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  }
});
