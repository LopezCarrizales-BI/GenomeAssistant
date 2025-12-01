document.addEventListener("DOMContentLoaded", () => {
  document.addEventListener("click", (e) => {
    const trigger = e.target.closest(".menu-trigger");
    const activeMenu = document.querySelector(".file-menu.active");

    if (trigger) {
      const parent = trigger.closest(".document-actions");
      const menu = parent.querySelector(".file-menu");

      if (activeMenu && activeMenu !== menu) {
        activeMenu.classList.remove("active");
        activeMenu.classList.remove("show");
      }

      if (menu) {
        menu.classList.toggle("active");
        menu.classList.toggle("show");
      }
      return;
    }

    if (activeMenu && !e.target.closest(".file-menu")) {
      activeMenu.classList.remove("active");
      activeMenu.classList.remove("show");
    }
  });

  const filesContainer = document.querySelector(".files");

  if (filesContainer) {
    filesContainer.addEventListener("click", async (e) => {
      const option = e.target.closest(".menu-option");
      if (!option) return;

      const documentItem = option.closest(".document-item");
      const id = documentItem.dataset.id;
      const currentName = documentItem.dataset.name;
      const menu = option.closest(".file-menu");

      const actionName = option
        .querySelector(".option-name")
        .textContent.trim();

      if (actionName === "Eliminar") {
        if (confirm(`¿Estás seguro de eliminar "${currentName}"?`)) {
          await deleteReport(id, documentItem);
        }
      }

      if (actionName === "Renombrar") {
        const newName = prompt("Nuevo nombre:", currentName);
        if (newName && newName !== currentName) {
          await renameReport(id, newName, documentItem);
        }
      }

      if (actionName === "Descargar") {
        await downloadReport(id, currentName);
      }

      menu.classList.remove("active");
      menu.classList.remove("show");
    });
  }

  async function deleteReport(id, element) {
    try {
      const res = await fetch(`${BASE_URL}/api/report/delete`, {
        method: "POST",
        body: JSON.stringify({ id }),
      });
      const data = await res.json();

      if (data.success) {
        element.remove();
      } else {
        alert("Error al eliminar: " + data.error);
      }
    } catch (error) {
      console.error(error);
    }
  }

  async function renameReport(id, newName, element) {
    try {
      const res = await fetch(`${BASE_URL}/api/report/rename`, {
        method: "POST",
        body: JSON.stringify({ id, newName }),
      });
      const data = await res.json();

      if (data.success) {
        element.dataset.name = newName;
        element.querySelector(".document-name").textContent = newName;
      } else {
        alert("Error al renombrar: " + data.error);
      }
    } catch (error) {
      console.error(error);
    }
  }

  async function downloadReport(id, filename) {
    try {
      const res = await fetch(`${BASE_URL}/api/report/get?id=${id}`);
      const responseData = await res.json();

      if (responseData.success) {
        generateCSV(responseData.data, filename);
      } else {
        alert("Error al descargar: " + responseData.error);
      }
    } catch (error) {
      console.error(error);
    }
  }

  function generateCSV(data, filename) {
    if (!data || data.length === 0) return;

    const headers = Object.keys(data[0]);
    const csvRows = [headers.join(",")];

    for (const row of data) {
      const values = headers.map((header) => {
        const val =
          row[header] !== null && row[header] !== undefined ? row[header] : "";
        const escaped = ("" + val).replace(/"/g, '\\"');
        return `"${escaped}"`;
      });
      csvRows.push(values.join(","));
    }

    const csvString = csvRows.join("\n");
    const blob = new Blob([csvString], { type: "text/csv" });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = filename + ".csv";
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  }
});
