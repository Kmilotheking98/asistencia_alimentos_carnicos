<?php
include_once "slidernavbar.php";
include_once "header.php";
include_once "functions.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
}

if ($_SESSION['permit'] ==3) {
    header("Location: employees.php");
}



$start = date("Y-m-d");
$end = date("Y-m-d");
if (isset($_GET["start"])) {
    $start = $_GET["start"];
}
if (isset($_GET["end"])) {
    $end = $_GET["end"];
}
$employees = getEmployeesWithAttendanceCount($start, $end);
?>

<!DOCTYPE html>

<body>
    <div class="employees-home ">
        <div class="col-12">
              <h1 class="text-left">REGISTRO DE ASISTENCIAS</h1>
        </div>
    <div class="col-12">

        <form action="attendance_report.php" class="form-inline mb-2">
            <label for="start">INICIO:&nbsp;</label>
            <input required id="start" type="date" name="start" value="<?php echo $start ?>" class="form-control mr-2">
            <label for="end">FIN:&nbsp;</label>
            <input required id="end" type="date" name="end" value="<?php echo $end ?>" class="form-control">
            <button class="btn btn-success ml-2">Filtrar</button>
        </form>
        <a href="./download_employee_report.php?start=<?php echo $start ?>&end=<?php echo $end ?>" class="btn btn__me">DESCARGAR INFORME DE ECXEL</a>
    </div>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr class="text-center">
                        <th> CODIGO DE EMPLEADO</th>
                        <th>EMPLEADO</th>
                        <th>ASISTENCIAS</th>
                        <th>INACISTENCIAS</th>
                    </tr>
                </thead>
                <tbody >
                    <?php foreach ($employees as $employee) { ?>
                        <tr class="text-center">
                        <td>
                                <?php echo $employee->cod ?>
                            </td>
                            <td>
                                <?php echo $employee->name ?>
                            </td>
                            <td>
                                <?php echo $employee->presence_count ?>
                            </td>
                            <td>
                                <?php echo $employee->absence_count ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
<?php
