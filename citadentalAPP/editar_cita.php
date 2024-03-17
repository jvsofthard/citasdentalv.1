<?php
// editar_cita.php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $paciente_id = $_POST["paciente_id"];
    $fecha_hora = $_POST["fecha_hora"];
    $tratamiento = $_POST["tratamiento"];

    $sql = "UPDATE citas SET paciente_id='$paciente_id', fecha_hora='$fecha_hora', tratamiento='$tratamiento' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Error al actualizar cita: " . $conn->error;
    }
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sqlCita = "SELECT * FROM citas WHERE id='$id'";
    $resultCita = $conn->query($sqlCita);
    if ($resultCita->num_rows > 0) {
        $row = $resultCita->fetch_assoc();
    } else {
        echo "No se encontró la cita";
    }
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cita</title>
    <link rel="stylesheet" href="css/estilos.css">
    
</head>
<body>
    <div class="container">

    <h2>Editar Cita</h2>




    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label for="paciente_id">Paciente:</label>
        <input type="text" name="paciente_id" value="<?php echo $row['paciente_id']; ?>" required>

        <label for="fecha_hora">Fecha y Hora:</label>
        <input type="datetime-local" name="fecha_hora" value="<?php echo date('Y-m-d\TH:i', strtotime($row['fecha_hora'])); ?>" required>

        <label for="tratamiento">Tratamiento:</label>
        <input type="text" name="tratamiento" value="<?php echo $row['tratamiento']; ?>" required>

        <button type="submit" onclick="mostrarMensaje()">Guardar Cambios</button>
    </form>
     <a href="citas.php">Atras</a>
    </div>
    <!-- Mensaje emergente -->
    <div id="mensaje-emergente" class="mensaje-emergente">
        Cita actualizada exitosamente
    </div>



    <script>
        function mostrarMensaje() {
            var mensajeEmergente = document.getElementById('mensaje-emergente');
            mensajeEmergente.style.display = 'block';
            setTimeout(function() {
                mensajeEmergente.style.display = 'none';
            }, 30000); // Ocultar el mensaje después de 3 segundos
        }
    </script>
</body>
</html>
