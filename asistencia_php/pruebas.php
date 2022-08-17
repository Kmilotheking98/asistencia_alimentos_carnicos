<?php
include_once "slidernavbar.php";
include_once "header.php";
include_once "functions.php";
$employees = getEmployees();
include("conexion.php");

if ($_SESSION['permit'] ==2) {
    header("Location: attendance_report.php");
}

?>


<!DOCTYPE html>

<body>

    <div class="employees-home ">

        <div class="barra-top">
            <div class="container-barra  bd-highlight">
                <div class="barra-buscar-container p-2 bd-highlight">

                    <form class='d-flex' action="buscar_employee.php" method="post">
                        <input placeholder="¿Qué deceas buscar?" class="form-control me-3" type="text" name="buscar"
                            id="">
                        <input class="btn btn__me" type='submit' value="Buscar"></input>
                    </form>

                </div>
                <div class="p-2 bd-highlight">

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    
                        <a href="employee_add.php" type="button" class="btn btn-warning me-md-2">
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
                    <tbody>
                        <?php foreach ($employees as $employee) { ?>
                        <tr>
                            <td>
                                <?php echo $employee->cod ?>
                            </td>
                            <td>
                                <?php echo $employee->name ?>
                            </td>
                            <td>
                                <?php echo $employee->last_name ?>
                            </td>
                            <td>
                                <?php echo $employee->dni ?>
                            </td>
                            <td>
                                <?php echo $employee->type_contract ?>
                            </td>
                            <td>
                                <?php echo $employee->date_birth ?>
                            </td>
                            <td>
                                <?php echo $employee->home ?>
                            </td>

                            <td>
                                <a class="btn btn-warning" href="employee_edit.php? cod=<?php echo $employee->cod ?>">
                                    Editar <i class="fa fa-edit"></i>
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="employee_delete.php?cod=<?php echo $employee->cod ?>">
                                    Borrar <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>

        </div>

    </div>
</body>

</html>

<?php