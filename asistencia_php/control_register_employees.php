<?php
require 'model_excel.php';

$ME = new Model_Excel();

$cod = htmlspecialchars($_POST['codem'],ENT_QUOTES,'UTF-8');
$name = htmlspecialchars($_POST['nam'],ENT_QUOTES,'UTF-8');
$last_name = htmlspecialchars($_POST['l_name'],ENT_QUOTES,'UTF-8');
$dni = htmlspecialchars($_POST['Dni'],ENT_QUOTES,'UTF-8');
$date_birth = htmlspecialchars($_POST['D_birth'],ENT_QUOTES,'UTF-8');
$type_contrac = htmlspecialchars($_POST['T_contract'],ENT_QUOTES,'UTF-8');
$home = htmlspecialchars($_POST['hme'],ENT_QUOTES,'UTF-8');

$array_cod = explode(",",$cod);// cuando encuentra una , lo separa y lo convierte en arreglo
$array_name = explode(",",$name);// cuando encuentra una , lo separa y lo convierte en arreglo
$array_last_name = explode(",",$last_name);// cuando encuentra una , lo separa y lo convierte en arreglo
$array_dni = explode(",",$dni);// cuando encuentra una , lo separa y lo convierte en arreglo
$array_date_birth = explode(",",$date_birth);// cuando encuentra una , lo separa y lo convierte en arreglo
$array_type_contract = explode(",",$type_contract);// cuando encuentra una , lo separa y lo convierte en arreglo
$array_home = explode(",",$home);// cuando encuentra una , lo separa y lo convierte en arreglo
    for($i = 0; $i < count($array_cod); $i++){
        $consulta = $ME-> GuardarExcel($array_cod[$i],$array_name[$i],$array_last_name[$i] ,$array_dni[$i] ,$array_date_birth[$i] ,$array_type_contract[$i] ,$array_home[$i]);
    }
    echo $consulta
?>