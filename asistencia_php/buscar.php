

<?php 
include("conexion.php");

?>


<!-- //resultados buscador -->
<?php 

if (!isset($_POST['buscar'])){$_POST['buscar'] = '';}
if (!isset($_REQUEST["mostrar_todo"])){$_REQUEST["mostrar_todo"] = '';}

if(!empty($_POST))
{

        // resaltamos el resultado
        function resaltar_frase($string, $frase, $taga = '<b>', $tagb = '</b>'){
            return ($string !== '' && $frase !== '')
            ? preg_replace('/('.preg_quote($frase, '/').')/i'.('true' ? 'u' : ''), $taga.'\\1'.$tagb, $string)
            : $string;
             }
    
  
      $aKeyword = explode(" ", $_POST['buscar']);
      $filtro = "WHERE  `employee_id`  LIKE LOWER('%".$aKeyword[0]."%') OR name LIKE LOWER('%".$aKeyword[0]."%')";
      $query ="SELECT * FROM employees WHERE  `employee_id`  LIKE LOWER('%".$aKeyword[0]."%') OR name LIKE LOWER('%".$aKeyword[0]."%')";
  

     for($i = 1; $i < count($aKeyword); $i++) {
        if(!empty($aKeyword[$i])) {
            $query .= " OR  `employee_id`  LIKE '%" . $aKeyword[$i] . "%' OR employee_id LIKE '%" . $aKeyword[$i] . "%'";
        }
      }
     
     $result = $conexion->query($query);
     $numero = mysqli_num_rows($result);
     if (!isset($_POST['buscar'])){
     echo "Has buscado la palabra:<b> ". $_POST['buscar']."</b>";
     }

     if( mysqli_num_rows($result) > 0 AND $_POST['buscar'] != '') {
        $row_count=0;
        echo "<br>Resultados encontrados:<b> ".$numero."</b>";
        echo "<br><br><table class='table table-striped'>
        <thead>
        <tr style='background-color:midnightblue; color:#FFFFFF;'>
        <th> # </th> 
        <th> id </th>       
        <th> NOMBRE </th>
                
        </tr>
        </thead>
        ";
        While($row = $result->fetch_assoc()) {   
            $row_count++;   
            echo "<tr><td>".$row_count." </td><td>". resaltar_frase($row['employee_id'] ,$_POST['buscar']) . "</td><td>". resaltar_frase($row['name'] ,$_POST['buscar']) . "</td></tr>";
        }
        echo "</table>";
	
    }
    else {
      //mostramos todos los resultados
      if( $_REQUEST["mostrar_todo"] == 'ok') {
        $row_count=0;
        echo "<br>Resultados encontrados:<b> ".$numero."</b>";
        echo "<br><br><table class='table table-striped'>";
        While($row = $result->fetch_assoc()) {   
            $row_count++;   
            echo "<tr><td>".$row_count." </td><td>". resaltar_frase($row['employee_id'] ,$_POST['buscar']) . "</td><td>". resaltar_frase($row['name'] ,$_POST['buscar']) . "</td></tr>";
        }
        echo "</table>";
	
    }
    }
}
?>