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
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
       
                <?php 
                    
                     
                    $query ="SELECT * FROM employees WHERE  `employee_id`  LIKE LOWER('%".$aKeyword[0]."%') OR name LIKE LOWER('%".$aKeyword[0]."%')";
                         for($i = 1; $i < count($aKeyword); $i++) {
                            if(!empty($aKeyword[$i])) {
                                $query .= " OR  `employee_id`  LIKE '%" . $aKeyword[$i] . "%' OR employee_id LIKE '%" . $aKeyword[$i] . "%'";
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
                                <a class="btn btn-warning" href="employee_edit.php?employee_id=<?php echo $employee['0'] ?>">
                                Edit <i class="fa fa-edit"></i>
                            </a>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="employee_delete.php?employee_id=<?php echo $employee['1']  ?>">
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