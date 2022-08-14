

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

<section class="home">

    <div class="container cont__me employees__content">
        <div class="col-12">
              <h1 class="text-left">EMPLEADOS</h1>
        </div>

        <div class='d-flex justify-content-end'>

        <a href="employee_add.php" type="button" class="btn btn-warning me-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                    class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                    <path fill-rule="evenodd"
                        d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                </svg>
                &nbspRegistrar Empleado
            </a>

            <form class='d-flex' action="buscar_employee.php" method="post">
                        <input style="width: 340px;" placeholder="¿Qué deceas buscar?" class="form-control me-3" type="text"
                            name="buscar" id="">
                        <input class="btn btn__me" type='submit' value="Buscar"></input>
            </form>

        </div>

    
        <div class="tabla__employees rounded border">
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
</section>

<?php