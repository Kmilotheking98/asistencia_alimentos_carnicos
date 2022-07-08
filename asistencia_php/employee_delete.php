<?php
if (!isset($_GET["employee_id"])) {
    exit("No data provided");
}
include_once "functions.php";
$employee_id = $_GET["employee_id"];
deleteEmployee($employee_id);
header("Location: employees.php");