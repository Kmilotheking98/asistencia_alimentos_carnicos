<?php
if (!isset($_POST["cod"])
|| !isset($_POST["name"]) 
|| !isset($_POST["last_name"]) 
|| !isset($_POST["dni"])
|| !isset($_POST["date_birth"]) 
|| !isset($_POST["home"]) 
) {
    exit("No data provided");
}
include_once "functions.php";
$cod = $_POST["cod"];
$name = $_POST["name"];
$last_name = $_POST["last_name"];
$dni= $_POST["dni"];
$date_birth = $_POST["date_birth"];
$home = $_POST["home"];

updateEmployee($cod, $name, $last_name, $dni, $date_birth, $home);
header("Location: employees.php");