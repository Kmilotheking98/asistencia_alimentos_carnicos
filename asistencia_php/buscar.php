<style>
  th, td{
    text-align: left;
  }
  .h2g{
    color: blue;
    font-size: 26px;
  }
  .pg{
    line-height: 2px;
  }
</style>

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
      $filtro = "WHERE  `id`  LIKE LOWER('%".$aKeyword[0]."%') OR name LIKE LOWER('%".$aKeyword[0]."%')";
      $query ="SELECT * FROM employees WHERE  `id`  LIKE LOWER('%".$aKeyword[0]."%') OR name LIKE LOWER('%".$aKeyword[0]."%')";
  

     for($i = 1; $i < count($aKeyword); $i++) {
        if(!empty($aKeyword[$i])) {
            $query .= " OR  `id`  LIKE '%" . $aKeyword[$i] . "%' OR id LIKE '%" . $aKeyword[$i] . "%'";
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
            echo "<tr><td>".$row_count." </td><td>". resaltar_frase($row['id'] ,$_POST['buscar']) . "</td><td>". resaltar_frase($row['name'] ,$_POST['buscar']) . "</td></tr>";
        }
        echo "</table>";
	
    }
    else if( $_REQUEST["mostrar_todo"] == 'ok') {
      //mostramos todos los resultados
       {
        $row_count=0;
        echo "<br>Resultados encontrados:<b> ".$numero."</b>";
        echo "<br><br><table class='table table-striped'>";
        While($row = $result->fetch_assoc()) {   
            $row_count++;   
            echo "<tr><td>".$row_count." </td><td>". resaltar_frase($row['id'] ,$_POST['buscar']) . "</td><td>". resaltar_frase($row['name'] ,$_POST['buscar']) . "</td></tr>";
        }
        echo "</table>";
	
    }
    }
}
?>