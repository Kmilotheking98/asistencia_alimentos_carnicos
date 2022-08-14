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

</section>

<?php