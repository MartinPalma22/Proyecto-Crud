<?php
include 'conexion.php';
include 'plantilla.php';

if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])){
    $id = (int) $_GET['id'];
    $estudiante = new Estudiante($id,'', '', '','');

    $conn = getConnection();
    $borrado = $estudiante->borrarEstudiante($conn, $id);
    $conn->close();

    if ($borrado){
        header("Location: listar.php");
        exit();
    } else {
        echo"Error al eliminar el estudiante.";
    }
} else {
    echo "ID de estudiante no proporcionado.";
}
?>