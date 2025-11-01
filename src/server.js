const express = require('express');
const app = express();
const port = 3000;

const apiRoutes = require('./routes/apiRoutes');

console.log("El objeto apiRoutes cargado es:", apiRoutes);

app.use(express.static('public'));

app.use('/api', apiRoutes);

app.listen(port, () => {
  console.log(`Servidor escuchando en http://localhost:${port}`);
});