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
    
        
        echo " <table id='tabla_detalles' class='table' style='width:100%; table-layout: fixed'>
        <thead>
            <tr>
                <th>CODIGO</th>
                <th>FECHA</th>
                <th>PUESTO</th>
                <th>ESTADO</th>
                <th>EVENTO</th>
                <th>TURNO</th>
            </tr>
        </thead>
        <tbody id='tbody_tabla_detalles'>";
           for($row = 2; $row<=$filas;$row++){
            $employee_id = $hoja -> getCell('A'.$row)->getvalue();
            $date = $hoja -> getCell('B'.$row)->getvalue(); // convertir la fecha de Excel a formato de fecha
            $job = $hoja -> getCell('C'.$row)->getvalue();
            $status = $hoja -> getCell('D'.$row)->getvalue();
            $status_event = $hoja -> getCell('E'.$row)->getvalue();
            $turn = $hoja -> getCell('F'.$row)->getvalue();
            $query = "select count(*) as contador from employee_attendance where employee_id='".$employee_id."' ";
            $resultado = $conexion->query($query);
            $respuesta = $resultado->fetch_assoc();
            if($respuesta['contador']=='0'){
                if($employee_id==""){

                }else{
                echo "<tr>";
                echo "<td>".$employee_id."</td>";
                echo "<td>".$date."</td>";
                echo "<td>".$job."</td>";
                echo "<td>".$status."</td>";
                echo "<td>".$status_event."</td>";
                echo "<td>".$turn."</td>"; 
                echo "</tr>";

            }
             }else{

             }
           } 
           echo "</tbody></table>";
    }


?>