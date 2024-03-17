<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];

    $sql = "UPDATE pacientes SET nombre='$nombre', apellido='$apellido', telefono='$telefono', email='$email' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "";
    } else {
        echo "Error al actualizar paciente: " . $conn->error;
    }
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sqlPaciente = "SELECT * FROM pacientes WHERE id='$id'";
    $resultPaciente = $conn->query($sqlPaciente);
    if ($resultPaciente->num_rows > 0) {
        $row = $resultPaciente->fetch_assoc();
    } else {
        echo "No se encontró el paciente";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Paciente</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
     <div class="container">
    
    <h2>Editar Paciente</h2>

    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>" required>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" value="<?php echo $row['apellido']; ?>" required>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" value="<?php echo $row['telefono']; ?>">

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $row['email']; ?>">

       <button type="submit" onclick="mostrarMensaje()">Guardar Cambios</button>
    </form>
     <a href="pacientes.php">Atras</a>
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
            }, 3000); // Ocultar el mensaje después de 3 segundos
        }
    </script>
</body>
</html>
