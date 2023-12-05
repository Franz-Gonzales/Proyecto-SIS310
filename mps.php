<?php
session_start();

//echo $_SESSION['nombre'];
if(!isset($_SESSION['nombre'])){
    header('Location:login.html');
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link
    rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
  />
    <title>MPS</title>
    <link rel="stylesheet" href="./Styles/styles.css">
    <script src="app.js"></script>
</head>
<body>
    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="menu.html">Herramientas de Producción</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./SIS310/index.html">Plan Maestro de Producción</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./SIS310/pareto.html">Diagrama de Pareto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./SIS310/menu.html">Plan Maestro de Producción (MPS)</a>
                </li>
            </ul>
        </div>
    </nav> -->
    <div class="container" id="container">
        <h1>Plan Maestro de Producción (MPS)</h1>
        <div class="contenido" id="contenido">
            <div class="datos">
                <label for="periodo">Seleccione el tipo de Periodo</label>
                <select name="periodo" id="periodo" onchange="javascript:tipoPeriodo()">
                    <option value="">Seleccione el Periodo</option>
                    <option value="semanal">Semanal</option>
                    <option value="mensual">Mensual</option>
                    <!-- <option value="trimestral">Trimestral</option> -->
                </select>
            </div>
        </div>
    </div>

</body>
</html> 