<?php
date_default_timezone_set('America/New_York'); 
if(is_array($_FILES['archivoexcel']) && count($_FILES['archivoexcel'])>0){
    // llamar a la libreria phpexcel
    require_once 'PHPExcel/Classes/PHPExcel.php';
    require_once 'conexion.php';

    $tmpfname = $_FILES['archivoexcel']['tmp_name'];
    // crea el excel para luego leerlo 
    $leerexcel = PHPExcel_IOFactory::createReaderForFile($tmpfname);
    // carga el Excel
    $excelobj = $leerexcel -> load($tmpfname);
    // cargar en que hoja trabajara el Excel 
    $hoja = $excelobj ->getSheet(0);
    $filas = $hoja -> getHighestRow();
    
    echo " <table id='tabla_detalle' class='table' style='width:100%; table-layout: fixed'>
        <thead>
            <tr>
                <th>CODIGO</th>
                <th>NOMBRE</th>
                <th>APELLIDOS</th>
                <th>CEDULA</th>
                <th>FECHA DE NACIMIENTO</th>
                <th>TIPO DE CONTRATO</th>
                <th>RESIDENCIA</th>
                <th>IMPORTE DE DATOS</th>
            </tr>
        </thead>
        <tbody id='tbody_tabla_detalle'>";
   for($row = 2; $row<=$filas;$row++){
        $cod = $hoja -> getCell('A'.$row)->getvalue();
        $name = $hoja -> getCell('B'.$row)->getvalue();
        $last_name = $hoja -> getCell('C'.$row)->getvalue();
        $dni = $hoja -> getCell('D'.$row)->getvalue();
        $excel_date = $hoja->getCell('E'.$row)->getValue();
        $date_birth = date('Y-m-d', strtotime('1899-12-30' . "+$excel_date days")); // convertir la fecha de Excel a formato de fecha
        $type_contract = $hoja -> getCell('F'.$row)->getvalue();
        $home = $hoja -> getCell('G'.$row)->getvalue();
        $query = "select count(*) as contador from employees where cod='".$cod."' ";
        $resultado = $conexion->query($query);
        $respuesta = $resultado->fetch_assoc();
        if($respuesta['contador']=='0'){
            if($cod==""){

            }else{
                echo "<tr>";
                echo "<td>".$cod."</td>";
                echo "<td>".$name."</td>";
                echo "<td>".$last_name."</td>";
                echo "<td>".$dni."</td>";
                echo "<td>".$date_birth."</td>";
                echo "<td>".$type_contract."</td>";
                echo "<td>".$home."</td>";
                echo "</tr>";

            }
        }else{
            // do something else
        }
   } 
   echo "</tbody></table>";
}