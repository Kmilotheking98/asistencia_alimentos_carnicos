<?php 
 //Conexion
 require "conexion.php";


 $sql = "SELECT id, nombre FROM empleados";

// Ejecutar la consulta
$resultado = mysqli_query($conexion, $sql);

// Crear un array asociativo con los nombres de los empleados y sus llaves primarias
$empleados = array();
while ($fila = mysqli_fetch_assoc($resultado)) {
    $empleados[$fila['id']] = $fila['nombre'];
}

// Mezclar el array al azar
shuffle($empleados);

// Itera sobre el array mezclado y asigna los turnos
foreach ($empleados as $id => $nombre) {
    $hora_ingreso = date('H:i:s');
    $hora_salida = date('H:i:s', strtotime('+8 hours')); // Suponemos una jornada laboral de 8 horas
    echo "Turno " . $id . ": " . $nombre . ", Hora de ingreso: " . $hora_ingreso . ", Hora de salida: " . $hora_salida . "\n";
}

// Cerrar la conexión a la base de datos
mysqli_close($conexion);

?>