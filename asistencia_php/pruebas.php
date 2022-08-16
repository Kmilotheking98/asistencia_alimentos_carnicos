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

    <!-- 1 Navbar Resposible -->




    <div class="employees-home ">

    
    </div>



  
</body>

</html>

<?php