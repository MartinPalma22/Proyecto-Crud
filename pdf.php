<?php
require('fpdf/fpdf.php');
include 'conexion.php';
include 'plantilla.php';

class PDF extends FPDF
{
    function Header()
    {
        $this->Image('images/logo.jpg', 10, 6, 30);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0,10, 'Lista de Estudiantes', 0,1, 'C');
        $this->Ln(30);
    }
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I', 8);
        $this->Cell(0,10,'Página' . $this->PageNo(), 0, 0, 'C');
    }
    function BasicTable($header, $data)
    {
        foreach($header as $col){
            $this->Cell(30, 7, $col, 1);
        }
        $this->Ln();
        foreach($data as $row){
            foreach($row as $col){
                $this->Cell(30, 6, $col, 1);
            }
            $this->Ln();
        }
    }

}

//Creación de objeto PDF
$pdf = new PDF ();
$pdf->AddPage();
$header = array ('id','nombre', 'rut', 'edad','carrera' );

$conn = getConnection();
$estudiantes = Estudiante :: listarEstudiantes($conn);
$data = [];

if ($estudiantes){
    foreach ($estudiantes as $estudiante){
        $data[] = array(
            $estudiante['id'],
            $estudiante['nombre'],
            $estudiante['rut'],
            $estudiante['edad'],
            $estudiante['carrera']
        );
    }
}  else {
    $data[] = array('-', '-', '-','-','-');
}
$pdf->SetFont('Arial', '', 12);
$pdf->BasicTable($header, $data);
$pdf->Output('lista_estudiantes.pdf', 'I');
?>