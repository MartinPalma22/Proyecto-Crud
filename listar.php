<!DOCTYPE html>
<html lang="en">
<head>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
  
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    

    
    <script src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="lista_1.css"> 
    <title>Lista</title>
</head>
<script>
    $(document).ready( function () {
    $('#myTable').DataTable({

        "language": {
            "lengthMenu": "Mostrar" +
                `<select class="custom-select custom-select-sm form-control form-control-sm">
                <option value = '10'>10</option>
                <option value = '25'>25</option>
                <option value = '50'>50</option>
                <option value ='100'>100</option>
                <option value = '-1'>Todos</option>
                </select>` +
                " registros por pagina",
            "zeroRecords": "Nada encontrado - Lo siento",
            "info": "Mostrando pagina _PAGE_de _PAGES_",
            "infoEmpty": "Registros no disponibles",
            "infoFiltered": "(filtrando de _MAX_registros totales)",
            'search': 'Buscar:',
            'paginate': {
                'next': 'Siguiente',
                'previous': 'Anterior'
        }
    }
});
});

</script>
<body>
<header>
    <nav class="navbar navbar-expand-lg mavbar-light bg-light">
        <a class="navbar-brand" href="agregar.php">Agregar Estudiante</a>
    </nav>
</header>
    
    <h2><center>Lista de Estudiantes</center></h2>
    <div class="container">
        <table id="myTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>RUT</th>
                    <th>Edad</th>
                    <th>Carrera</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'conexion.php';
                include 'plantilla.php';

                $conn = getConnection();
                $estudiantes = Estudiante::listarEstudiantes($conn);

                if($estudiantes) {
                    foreach ($estudiantes as $estudiante){
                        echo "<tr>";
                        echo "<td>" . $estudiante['id'] . "</td>";
                        echo "<td>" . $estudiante['nombre'] . "</td>";
                        echo "<td>" . $estudiante['rut'] . "</td>";
                        echo "<td>" . $estudiante['edad'] . "</td>";
                        echo "<td>" . $estudiante['carrera'] . "</td>";
                        echo "<td>
                                <a href='editar.php?id=" . $estudiante['id'] . "' class='btn btn-primary btn-sm'>Editar</a>
                                <a href='eliminar.php?id=" . $estudiante['id'] . "' class='btn btn-danger btn-sm'
                                onclick='return confirm(\"¿Estás seguro de eliminar este registro?\");'>Eliminar</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay estudiantes registrados</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
        <div class="text-center mt-3">
            <a href="pdf.php" class="btn btn-primary btn-sm">Imprimir</a>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
</body>
</html>

