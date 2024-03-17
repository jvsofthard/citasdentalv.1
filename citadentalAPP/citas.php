<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paciente_id = $_POST["paciente_id"];
    $fecha_hora = $_POST["fecha_hora"];
    $tratamiento = $_POST["tratamiento"];

    $sql = "INSERT INTO citas (paciente_id, fecha_hora, tratamiento) VALUES ('$paciente_id', '$fecha_hora', '$tratamiento')";
    if ($conn->query($sql) === TRUE) {
        echo "Cita agregada exitosamente";
    } else {
        echo "Error al agregar cita: " . $conn->error;
    }
}

if (isset($_GET["eliminar"])) {
    $idEliminar = $_GET["eliminar"];
    $sqlEliminar = "DELETE FROM citas WHERE id=$idEliminar";

    if ($conn->query($sqlEliminar) === TRUE) {
        echo "Cita eliminada exitosamente";
    } else {
        echo "Error al eliminar cita: " . $conn->error;
    }
}

$sqlPacientes = "SELECT * FROM pacientes";
$resultPacientes = $conn->query($sqlPacientes);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Citas</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
	<div class="container">
    <h2>Gestionar Citas</h2>

        <form method="POST" action="" class="add-form">
            <label for="paciente_id">Paciente:</label>
            <select name="paciente_id" required>
            <?php
            if ($resultPacientes->num_rows > 0) {
                while ($row = $resultPacientes->fetch_assoc()) {
                    echo "<option value='" . $row["id"] . "'>" . $row["nombre"] . " " . $row["apellido"] . "</option>";
                }
            } else {
                echo "<option value='' disabled>No hay pacientes registrados</option>";
            }
            ?>
         </select>

            <label for="fecha_hora">Fecha y Hora:</label>
            <input type="datetime-local" name="fecha_hora" required>

            <label for="tratamiento">Tratamiento:</label>
            <input type="text" name="tratamiento" required>

            <button type="submit">Agregar Cita</button>
        </form>

        <form method="GET" action="" class="search-form">
            <label for="buscar">Buscar:</label>
            <input type="text" name="buscar" placeholder="Ingrese término de búsqueda">
            <button type="submit">Buscar</button>
        </form>


    <table border="1">
        <thead>
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Fecha y Hora</th>
                    <th>Tratamiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
        <?php
        $sqlCitas = "SELECT citas.id, CONCAT(pacientes.nombre, ' ', pacientes.apellido) AS paciente, citas.fecha_hora, citas.tratamiento
                     FROM citas
                     INNER JOIN pacientes ON citas.paciente_id = pacientes.id";
        $resultCitas = $conn->query($sqlCitas);

        if ($resultCitas->num_rows > 0) {
            while ($row = $resultCitas->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["paciente"] . "</td>
                        <td>" . $row["fecha_hora"] . "</td>
                        <td>" . $row["tratamiento"] . "</td>
                        <td>
                            <a href='citas.php?eliminar=" . $row["id"] . "'>Eliminar</a>
                            <a href='editar_cita.php?id=" . $row["id"] . "'>Modificar</a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No hay citas registradas</td></tr>";
        }
        ?>
   		</tbody>
    </table>
    
    <button type="inicio"><a href="index.php">INICIO</a></button>
   
	</div>
</body>
</html>
