<?php
if (!isset($_GET["cod"])) {
    exit("No data provided");
}
include_once "functions.php";
$cod = $_GET["cod"];
deleteEmployee($cod);
header("Location: employees.php");