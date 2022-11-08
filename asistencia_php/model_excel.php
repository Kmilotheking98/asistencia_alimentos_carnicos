<?php
class Model_Excel{
    private $conexion;
    function __construct(){
        require_once 'modelo_conexion.php';
        $this-> conexion = new conexion();
        $this-> conexion -> conectar();
    }
// GUARDAR EN EL CAMPO DE EMPLEADOS
    function GuardarExcel_employees($cod,$name,$last_name,$dni,$date_birth,$type_contract,$home){
        $sql = "call PA_REGISTRAR_EMPLOYEE_EXCEL('$cod','$name','$last_name','$dni','$date_birth','$type_contract','$home')";
        if ($resultado = $this->conexion->conexion->query($sql)){
            $id_retornado = mysqli_insert_id($this->conexion->conexion);
            return 1;
        }
        else {
            return 0;
        }
        $this->conexion->Cerrar_conexion();
    }
    // GUARDAR EN EL CAMPO DE ASISTENCIA
    function GuardarExcel_attendaces($employee_id,$date,$job,$status,$status_event,$turn){
        $sql = "call PA_REGISTRAR_EMPLOYEE_EXCEL('$employee_id','$date','$job','$status','$status_event','$turn')";
        if ($resultado = $this->conexion->conexion->query($sql)){
            $id_retornado = mysqli_insert_id($this->conexion->conexion);
            return 1;
        }
        else {
            return 0;
        }
        $this->conexion->Cerrar_conexion();
    }
    // toca implementar..
    function ActualizarExcel($cod,$name,$last_name,$dni,$date_birth,$type_contract,$home){
        $sql = "call PA_ACTUALIZAR_EMPLOYEE_EXCEL('$cod','$name','$last_name','$dni','$date_birth','$type_contract','$home')";
        if ($resultado = $this->conexion->conexion->query($sql)){
            $id_retornado = mysqli_insert_id($this->conexion->conexion);
            return 1;
        }
        else{
            return 0;
        }
        $this->conexion->Cerrar_conexion();
    }

}
?>