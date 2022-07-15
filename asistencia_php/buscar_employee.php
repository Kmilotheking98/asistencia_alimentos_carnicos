<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
$employees = getEmployees();
include("conexion.php");
?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">Employees</h1>
    </div>
    <div class="col-12">
        <a href="employee_add.php" class="btn btn-info mb-2">Add new employee <i class="fa fa-plus"></i></a>

     </div>
     <div>
        <?php
          $aKeyword= explode(" ", $_POST['buscar']);
        ?>
     <div>
        <form action="buscar_employee.php" method="post">
            <input type="text" name="buscar" id="" >
            <input type="submit" value="Buscar">
        </form>
     </div>
     <div class="col-12">
        <div class="table-responsive">
            <table class="table">
                <thead>                    
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>last Name</th>
                        <th>DNI</th>
                        <th>Date Birth</th>
                        <th>Home</th>                        
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
       
                <?php 
                    
                    // largo de la busqueda 
                    $query ="SELECT * FROM employees WHERE  `cod`  LIKE LOWER('%".$aKeyword[0]."%') OR name LIKE LOWER('%".$aKeyword[0]."%') OR last_name LIKE LOWER('%".$aKeyword[0]."%') OR dni LIKE LOWER('%".$aKeyword[0]."%') OR date_birth LIKE LOWER('%".$aKeyword[0]."%') OR home LIKE LOWER('%".$aKeyword[0]."%')";
                    // cantidad de capos que recorrer 
                         for($i = 5; $i < count($aKeyword); $i++) {
                            if(!empty($aKeyword[$i])) {
                                $query .= "OR  `cod`  LIKE '%" . $aKeyword[$i] . "%' OR cod LIKE '%" . $aKeyword[$i] . "%'";
                            }
                          }
                         
                         $result = $conexion->query($query);
                         $numero = mysqli_num_rows($result);

                         if( mysqli_num_rows($result) > 0 AND $_POST['buscar'] != '') {
                        
                       //  echo ($);
                       //  $filtrar = search($buscar);
                         
                        while($employee=mysqli_fetch_row($result)){ ?>
     
                <tbody>
                        <tr>
                            <td>
                                <?php echo $employee['0'] ?>
                            </td>
                            <td>
                                <?php echo $employee['1'] ?>
                            </td>
                            <td>
                                <?php echo $employee['2'] ?>
                            </td>
                            <td>
                                <?php echo $employee['3'] ?>
                            </td>                            
                            <td>
                                <?php echo $employee['4'] ?>
                            </td>
                            <td>
                                <?php echo $employee['5'] ?>
                            </td>
                            <td>
                                <a class="btn btn-warning" href="employee_edit.php?cod=<?php echo $employee['0'] ?>">
                                Edit <i class="fa fa-edit"></i>
                            </a>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="employee_delete.php?cod=<?php echo $employee['1']  ?>">
                                Delete <i class="fa fa-trash"></i>
                            </a>
                            </td>
                        </tr>
                    <?php   }}else{
                        echo"<br>No se encontro<b> ";
                    } ?> 
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
include_once "footer.php";