<?php
include 'conexion.php';
include 'plantilla.php';

function validate_input($data){
    return htmlspecialchars(trim($data));
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset ($_GET['id'])){
    $id = (int) $_GET['id'];

    $conn = getConnection();
    $stmt = $conn->prepare("SELECT nombre, rut, edad, carrera FROM alumno WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nombre, $rut, $edad, $carrera);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    if ($nombre !== null){

        ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="editar_1.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Editar</title>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg mavbar-light bg-light">
        <a class="navbar-brand" href="agregar.php">Agregar Estudiante</a>
        <a class="navbar-brand" href="listar.php">Ver todos</a>
    </nav>
</header>
<div class="container mt-5">
<h2>Editar Estudiante</h2>
<script languaje = "javascript">
        function ValidaSoloNumeros(){
            if((event.keyCode < 48) || (event.keyCode > 57))
                event.returnValue = false;
        }

        function ValidaSoloLetras(){
            if((event.keyCode != 32) && (event.keyCode < 65) || (event.keyCode > 90) && (event.keyCode < 97) || (event.keyCode > 122))
                event.returnValue = false;
        }
    </script>
    <form action="editar.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <div class="form-group">
            <label for="nombre">Nombre :</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre;?>" onkeypress="ValidaSoloLetras()" required>
        </div>
        <div class="form-group">
            <label for="rut">RUT :</label>
            <input type="text" class="form-control" id="rut" name="rut" value="<?php echo $rut;?>" required>
        </div>
        <div class="form-group">
            <label for="edad">Edad :</label>
            <input type="number" class="form-control" id="edad" name="edad" value="<?php echo $edad;?>" onkeypress="ValidaSoloNumeros()" required>
        </div>
        <div class="form-group">
            <label for="carrera">Carrera :</label>
            <input type="text" class="form-control" id="carrera" name="carrera" value="<?php echo $carrera;?>" onkeypress="ValidaSoloLetras()" required>
        </div>  
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </form>
</div>    
</body>
</html>

<?php
    } else {
        echo"No se han encontrado datos del estudiante";
    }
}elseif ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['id'])){
        $id = (int) $_POST['id'];
        $nombre = validate_input($_POST['nombre']);
        $rut = validate_input($_POST['rut']);
        $edad = (int) $_POST['edad'];
        $carrera = validate_input($_POST['carrera']);

        $estudiante = new Estudiante($id, $nombre, $rut, $edad, $carrera);
        $conn = getConnection();
    
        if($estudiante->editarEstudiante($conn)){
            header("Location: agregar.php");
            exit();
        } else {
            echo "<div class='alert alert-danger mt-4' role='alert'>Error al actualizar el estudiante</div>";
        }

        $conn->close();
    }
}

?>