const express = require('express');
const { exec } = require('child_process');
const app = express();

// Esto levanta un servidor que ejecuta tu proyecto PHP
app.use((req, res) => {
    exec('php -S 0.0.0.0:8080 -t public', (err, stdout, stderr) => {
        if (err) console.error(err);
    });
});

app.listen(8080);
