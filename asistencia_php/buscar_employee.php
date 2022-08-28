<?php
include_once "slidernavbar.php";
include_once "header.php";
include_once "functions.php";
$employees = getEmployees();
include("conexion.php");

if ($_SESSION['permit'] == 2) {
    header("Location: attendance_report.php");
}

?>

<!DOCTYPE html>

<body>

        <?php
          $aKeyword= explode(" ", $_POST['buscar']);
        ?>

    <div class="employees-home ">
        <div class="col-12">
              <h1 class="text-left">BUSQUEDA DE EMPLEADOS</h1>
        </div>
        <div class="barra-top">
            <div class="container-barra  bd-highlight">
                <div class="barra-buscar-container p-2 bd-highlight">

                    <form class='d-flex' action="buscar_employee.php" method="post">
                        <input placeholder="¿Qué deceas buscar?" class="form-control me-3" type="search" name="buscar"
                            id="">
                        <input class="btn btn__me" type='submit' value="Buscar"></input>
                    </form>

                </div>
                <div class="p-2 bd-highlight">

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    
                        <a href="employee_add.php" type="button" class="btn btn-warning me-md-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                <path fill-rule="evenodd"
                                    d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                            </svg>                            
                            &nbspRegistrar Empleado
                        </a>
                           
                    </div>

                </div>
            </div>
        </div>

        <div class='table-container'>

        <div class="tabla__employees rounded ">
            <div class="table-responsive">
                <table class="table">
                <?php  if($_POST['buscar'] !=""){ ?>
                    <thead>
                        <tr>
                            <th>CODIGO</th>
                            <th>NOMBRE</th>
                            <th>APELLIDOS</th>
                            <th>CEDULA</th>
                            <th>TIPO DE CONTRATO</th>
                            <th>FECHA DE NACIMIENTO</th>
                            <th>RESIDENCIA</th>
                            <th>EDITAR</th>
                            <th>ELIMINAR</th>
                        </tr>
                    </thead>

                        <?php 
                    }
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
                            echo"<br> <p style='font-size:30px;font-weight:bold;'>Resultados de la busqueda...</p><br> ";                            
                        while($employee=mysqli_fetch_row($result)){ ?>

                        <tbody>
                            <tr>
                                <td class="text-center">
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
                                        Editar
                                     <!-- <i class="bx bx-edit-alt icon"> -->
                                     <i></i>
                                    </a>
                                </td>
                                <td> 
                                    <?php
                                    // capturar codigo en variable para que pueda eliminar por mediante la busqueda  
                                    $cod = $employee['0']; 
                                   // echo"$cod";
                                     ?>                                  
                                <a class="btn btn-danger" href="#" onclick="question(<?php echo $cod ?>)">                                    
                                    <!-- <a 
                                        href="employee_delete.php?cod="> -->
                                        Borrar 
                                        <!-- <i class="bx bx-trash-alt icon" > -->
                                        <i></i>
                                    </a>
                                </td>                                
                                                         
                            </tr>
                            <?php   }}elseif($_POST['buscar']==""){
                                echo"<br> <p style='font-size:30px;font-weight:bold;'>Por favor ingresar dato a buscar del empleado...</p><br> ";
                            }else{
                                echo"<br> <p style='font-size:30px;font-weight:bold;'>No se encontro el empleado...</p><br> ";
                            } ?>
                    </tbody>
                    <script type="text/javascript">
                  function question($cod){

                        Swal.fire({
                            title: '¿Está seguro?',
                            text: "¡No podrás revertir esto!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#695CFE',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '¡Si, Borralo!',
                            cancelButtonText: '¡No, Cancelar!'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "employee_delete.php?cod="+$cod;
                               
                            }
                            })
                                
                  }

                    </script>                          
                </table>
            </div>

        </div>

        </div>

    </div>
</body>

</html>

<?php