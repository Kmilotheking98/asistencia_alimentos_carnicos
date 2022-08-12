<?php
include_once "slidernavbar.php";
include_once "header.php";
include_once "functions.php";
$employees = getEmployees();
include("conexion.php");
?>


<section class="home">
    <div class="container cont__me employees__content">

            <?php
          $aKeyword= explode(" ", $_POST['buscar']);
        ?>

            <div class='d-flex justify-content-end'>

            <a href="employee_add.php" type="button" class="btn btn-warning me-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                    class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                    <path fill-rule="evenodd"
                        d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                </svg>
                &nbspAdd new employee
            </a>
    
                <form  class='d-flex' action="buscar_employee.php" method="post">
                    <input class="form-control me-3" style="width: 340px;" type="text" name="buscar" id="">
                    <input class="btn btn__me" type="submit" value="Buscar">
                </form>
            </div>


            <div class="tabla__employees rounded border">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>last Name</th>
                                <th>DNI</th>                              
                                <th>Type Of Contract</th>
                                <th>Date Birth</th> 
                                <th>Home</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>

                        <?php 
                    
                    // largo de la busqueda 
                    $query ="SELECT * FROM employees WHERE  `cod`  LIKE LOWER('%".$aKeyword[0]."%') OR name LIKE LOWER('%".$aKeyword[0]."%') OR last_name LIKE LOWER('%".$aKeyword[0]."%') OR dni LIKE LOWER('%".$aKeyword[0]."%') OR type_contract LIKE LOWER('%".$aKeyword[0]."%') OR date_birth LIKE LOWER('%".$aKeyword[0]."%') OR home LIKE LOWER('%".$aKeyword[0]."%')";
                    // cantidad de capos que recorrer 
                         for($i = 6; $i < count($aKeyword); $i++) {
                            if(!empty($aKeyword[$i])) {
                                $query .= "OR  `cod`  LIKE '%" . $aKeyword[$i] . "%' OR cod LIKE '%" . $aKeyword[$i] . "%'";
                            }
                          }
                         
                         $result = $conexion->query($query);
                         $numero = mysqli_num_rows($result);

                         if( mysqli_num_rows($result) > 0 AND $_POST['buscar'] != '') {
                            
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
                                    <?php echo $employee['5'] ?>
                                </td>
                                <td>
                                    <?php echo $employee['4'] ?>
                                </td>
                                <td>
                                    <?php echo $employee['6'] ?>
                                </td>                                
                                <td>
                                    <a class="btn btn-warning"
                                        href="employee_edit.php?cod=<?php echo $employee['0'] ?>">
                                        Edit <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-danger"
                                        href="employee_delete.php?cod=<?php echo $employee['1']  ?>">
                                        Delete <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php   }}else{
                        echo"<br> <p style='font-size:30px;font-weight:bold;'>No se encontro el empleado</p><br> ";
                    } ?>
                        </tbody>
                    </table>
                </div>
            </div>


       
</section>







<?php
