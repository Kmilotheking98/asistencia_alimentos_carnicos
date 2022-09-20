<?php
session_start();
include_once "slidernavbar.php";
include_once "header.php";
include_once "functions.php";
$employees = getEmployees();
include("conexion.php");

if (isset($_SESSION['user'])) {
    if ($_SESSION['permit'] == 2) {
        header("Location: attendance_report.php");
    }

}else{
    header('Location: login.php');
}
?>


<!DOCTYPE html>

<body>

    <div class="employees-home ">
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
                        <?php

                                if (isset($_SESSION['msj'])){ 
                                    $respuesta = $_SESSION['msj'];?>
                        <script>
                            Swal.fire(
                                '<?php echo $_SESSION['info']; ?>',
                                '<?php echo $respuesta; ?>',
                                //'REGISTRO EXITOSO',
                                'success'
                            )
                        </script>

                        <?php 
                                unset($_SESSION['info']);
                                unset($_SESSION['msj']);
                            } ?>
                    </div>

                </div>

                <div class="fs-3 me-auto p-2 bd-highlight">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                    class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                    <path fill-rule="evenodd"
                        d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                </svg>
                <span style="font-weight: 500;"  class="profession"><?php echo $user; ?></span>
            </div>

            </div>
        </div>

        <div class='table-container shadow-sm'>

            <div class="tabla__employees rounded ">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="sticky-top">
                            <tr>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Cedula</th>
                                <th>Tipo de contrato</th>
                                <th>Fecha de nacimiento</th>
                                <th>Residencia</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($employees as $employee) { ?>
                            <tr>
                                <td class="text-center">
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
                                    <a class="btn btn-warning"
                                        href="employee_edit.php? cod=<?php echo $employee->cod ?>">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                        </svg>


                                    </a>
                                </td>
                                <td>

                                    <a class="btn btn-danger" href="#" onclick="question(<?php echo $employee->cod ?>)">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                        </svg>


                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                        <script type="text/javascript">
                            function question(cod) {

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
                                        window.location.href = "employee_delete.php?cod=" + cod;

                                    }
                                })


                        Swal.fire({
                            title: '¿Está seguro?',
                            text: "¡No podrás revertir esto!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmBut``                                                tonColor: '#d33',
                            cancelButtonColor: '#695CFE',
                            confirmButtonText: '¡Si, Borralo!',
                            cancelButtonText: '¡No, Cancelar!'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "employee_delete.php?cod="+cod;
                               

                            }

                        </script>
                    </table>
                </div>

            </div>

        </div>

    </div>
</body>

</html>

