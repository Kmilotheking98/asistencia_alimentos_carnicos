<?php
if (!isset($_POST["name"])) {
    exit("No data provided");
}
include_once "functions.php";
$attendance_id = $_POST["attendance_id"];
$employee_id = $_POST["employee_id"];
$date_attendance = $_POST["date_attendance"];
$job = $_POST["job"];
$status= $_POST["status"];
$status_event = $_POST["status_event"];
$turn = $_POST["turn"];

saveAttendance($attendance_id,$employee_id, $date_attendance, $job, $status, $status_event, $turn);
header("Location: attendace_register.php");