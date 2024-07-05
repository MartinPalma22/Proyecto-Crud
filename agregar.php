<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo_agregar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <title>Agregar Estudiante</title>
    <style>
        .error {
            color: red;
            display: none;
        }

        .btn-custom {
            background-color: #00bfff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #009acd;
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="listar.php">Ver todos</a>
    </nav>
</header>
<div class="container mt-5">
    <h2>Agregar Estudiante</h2>
    <form id="formulario" action="agregar.php" method="post">
        <div class="form-group mb-3">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" onkeypress="ValidaSoloLetras()" required>
        </div>
        <div class="form-group mb-3">
            <label for="rut">RUT:</label>
            <input type="text" class="form-control" id="rut" name="rut" required>
            <div class="error" id="rutError">RUT inválido, corríjalo</div>
        </div>
        <div class="form-group mb-3">
            <label for="edad">Edad:</label>
            <input type="number" class="form-control" id="edad" name="edad" onkeypress="ValidaSoloNumeros()" required>
        </div>
        <div class="form-group mb-3">
            <label for="carrera">Carrera:</label>
            <input type="text" class="form-control" id="carrera" name="carrera" onkeypress="ValidaSoloLetras()" required>
        </div>
        <button type="submit" class="btn btn-custom">Agregar</button>
        <a href="listar.php" class="btn btn-custom">Listado</a>
    </form>

    <?php
    include 'conexion.php';
    include 'plantilla.php';

    function validate_input($data) {
        return htmlspecialchars(trim($data));
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre = validate_input($_POST['nombre']);
        $rut = validate_input($_POST['rut']);
        $edad = (int)$_POST['edad'];
        $carrera = validate_input($_POST['carrera']);

        $conn = getConnection();
        $estudiante = new Estudiante(null, $nombre, $rut, $edad, $carrera);

        if ($estudiante->crearEstudiante($conn)) {
            echo "<div class='alert alert-success mt-4' role='alert'>Nuevo estudiante agregado exitosamente.</div>";
        } else {
            echo "<div class='alert alert-danger mt-4' role='alert'>Error al agregar el estudiante.</div>";
        }

        $conn->close();
    }
    ?>
</div>
<script>
    function ValidaSoloNumeros() {
        if ((event.keyCode < 48) || (event.keyCode > 57)) {
            event.returnValue = false;
        }
    }

    function ValidaSoloLetras() {
        if ((event.keyCode != 32) && (event.keyCode < 65) || (event.keyCode > 90) && (event.keyCode < 97) || (event.keyCode > 122)) {
            event.returnValue = false;
        }
    }

    function validarRUT(rut) {
        rut = rut.replace(/\./g, '').replace('-', '');
        if (rut.length < 8) {
            return false;
        }
        const cuerpo = rut.slice(0, -1);
        let dv = rut.slice(-1).toUpperCase();

        let suma = 0;
        let multiplo = 2;

        for (let i = cuerpo.length - 1; i >= 0; i--) {
            suma += multiplo * cuerpo.charAt(i);
            multiplo = multiplo < 7 ? multiplo + 1 : 2;
        }

        const dvEsperado = 11 - (suma % 11);
        const dvEsperadoStr = dvEsperado === 11 ? '0' : dvEsperado === 10 ? 'K' : dvEsperado.toString();

        return dv === dvEsperadoStr;
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('formulario').addEventListener('submit', function (event) {
            const rut = document.getElementById('rut').value;
            if (!validarRUT(rut)) {
                event.preventDefault();
                document.getElementById('rutError').style.display = 'block';
            } else {
                document.getElementById('rutError').style.display = 'none';
            }
        });
    });
</script>
</body>
</html>
