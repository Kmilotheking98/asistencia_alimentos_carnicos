<?php
require 'model_excel.php';

$ME = new Model_Excel();

$employee_id = htmlspecialchars($_POST['emp_id'],ENT_QUOTES,'UTF-8');
$date = htmlspecialchars($_POST['d'],ENT_QUOTES,'UTF-8');
$job = htmlspecialchars($_POST['j'],ENT_QUOTES,'UTF-8');
$status = htmlspecialchars($_POST['st'],ENT_QUOTES,'UTF-8');
$status_event = htmlspecialchars($_POST['st_ev'],ENT_QUOTES,'UTF-8');
$turn = htmlspecialchars($_POST['turno'],ENT_QUOTES,'UTF-8');

$array_employee_id = explode(",",$employee_id);// cuando encuentra una , lo separa y lo convierte en arreglo
$array_date = explode(",",$date);// cuando encuentra una , lo separa y lo convierte en arreglo
$array_job = explode(",",$job);// cuando encuentra una , lo separa y lo convierte en arreglo
$array_status = explode(",",$status);// cuando encuentra una , lo separa y lo convierte en arreglo
$array_status_event = explode(",",$status_event);// cuando encuentra una , lo separa y lo convierte en arreglo
$array_turn = explode(",",$turn);// cuando encuentra una , lo separa y lo convierte en arreglo

    for($i = 0; $i < count($array_employee_id); $i++){
        $consulta = $ME-> GuardarExcel($array_employee_id[$i],$array_date[$i],$array_job[$i] ,$array_status[$i] ,$array_status_event[$i] ,$array_turn[$i]);
    }
    echo $consulta
?>