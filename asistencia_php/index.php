<?php session_start(); ?>
<?php
     
if (isset($_SESSION['user'])) {
    switch($_SESSION['permit']){
        case 1:

            header("Location: employees.php");
        break;
        case 2:
            header("Location: attendance_report.php");
        break;

        default:
        

   }

}else{
    header('Location: login.php');
}