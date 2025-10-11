document.getElementById("search-form").addEventListener("submit", function (e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch("consulta.php", {
    method: "POST",
    body: formData,
  })
    .then((res) => res.text())
    .then((data) => {
      document.getElementById("result").innerHTML = `<pre>${data}</pre>`;
    })
    .catch((err) => {
      document.getElementById("result").innerHTML = `<p>Error: ${err}</p>`;
    });
});
