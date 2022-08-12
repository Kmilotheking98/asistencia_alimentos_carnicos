<?php
?>
<?php
     session_start();
if (isset($_SESSION['user'])) {
// header("Location: employees.php");

    switch($_SESSION['permit']){
        case 1:

            header("Location: employees.php");
        break;
        case 2:
            header("Location: attendance_report.php");
        break;

        default:
        

   }






}