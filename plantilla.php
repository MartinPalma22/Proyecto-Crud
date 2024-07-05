<?php

class Estudiante {

    private $id;
    private $nombre;
    private $rut;
    private $edad;
    private $carrera;

    public function __construct($id, $nombre, $rut, $edad, $carrera) {

        $this->id = $id;
        $this->nombre = $nombre;
        $this->rut = $rut;
        $this->edad = $edad;
        $this->carrera = $carrera;
    }

    public function crearEstudiante($conn) {
        $stmt = $conn->prepare("INSERT INTO alumno (nombre, rut, edad, carrera) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $this->nombre, $this->rut, $this->edad, $this->carrera);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        $stmt->close();
        
    }

    public static function listarEstudiantes($conn){

        $stmt = $conn->prepare("SELECT id, nombre, rut, edad, carrera FROM alumno");

        if($stmt->execute()){
            $result = $stmt->get_result();
            $estudiantes = [];

            while ($row = $result->fetch_assoc()){
                $estudiantes[] = $row;
            }

            return $estudiantes;
        } else {
            return false;
        }

        $stmt->close();

    }

    public function editarEstudiante($conn) {
        $sql = "UPDATE alumno SET nombre = ?, rut = ?, edad = ?, carrera = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssisi', $this->nombre, $this->rut, $this->edad, $this->carrera, $this->id);

        return $stmt->execute();

    }

    public function borrarEstudiante($conn) {
        $sql = "DELETE FROM alumno WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $this->id);
        return $stmt->execute();
    }



}

?>