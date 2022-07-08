<?php
if (!isset($_POST["name"])) {
    exit("No data provided");
}
include_once "functions.php";
$employee_id = $_POST["employee_id"];
$name = $_POST["name"];
$last_name = $_POST["last_name"];
$dni= $_POST["dni"];
$date_birth = $_POST["date_birth"];
$home = $_POST["home"];

saveEmployee($employee_id, $name, $last_name, $dni, $date_birth, $home);
header("Location: employees.php");