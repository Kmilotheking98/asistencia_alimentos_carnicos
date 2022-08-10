<?php
?>
<?php
     session_start();
if (isset($_SESSION['user'])) {

   
if(isset($_SESSION['permit'])){
    switch($_SESSION['permit']){
        case 'Admin':

            header("Location: employees.php");
        break;
        case 'Colaborador1':
;
            header("Location: attendance_report.php");
        break;

        default:
        
        }

   }






}