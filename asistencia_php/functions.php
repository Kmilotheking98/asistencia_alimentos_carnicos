<?php
function getEmployeesWithAttendanceCount($start, $end)
{
    $query = "select employees.cod, employees.name, 
sum(case when status = 'presence' then 1 else 0 end) as presence_count,
sum(case when status = 'absence' then 1 else 0 end) as absence_count 
 from employee_attendance
 inner join employees on employees.cod = employee_attendance.employee_id
 where date >= ? and date <= ?
 group by employee_id;";
    $db = getDatabase();
    $statement = $db->prepare($query);
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
}

function saveAttendanceData($date, $employees)
{
    // session_start();
    // $_SESSION['info_r']= 'Datos Registrados!';
    // $_SESSION['msj_r']= "El registro de asistencias se ha completado";
    
    deleteAttendanceDataByDate($date);
    $db = getDatabase();
    $db->beginTransaction();
    $statement = $db->prepare("INSERT INTO employee_attendance(employee_id, date, job, status, status_event, turn) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($employees as $employee) {
        $statement->execute([$employee->cod, $date, $employee->job, $employee->status, $employee->status_event, $employee->turn]);
    }
    $db->commit();
    return true;
}

function deleteAttendanceDataByDate($date)
{
    $db = getDatabase();
    $statement = $db->prepare("DELETE FROM employee_attendance WHERE date = ?");
    return $statement->execute([$date]);
}
function getAttendanceDataByDate($date)
{
    $db = getDatabase();
    $statement = $db->prepare("SELECT employee_id, job, status, status_event, turn FROM employee_attendance WHERE date = ?");
    $statement->execute([$date]);
    return $statement->fetchAll();
}

function deleteEmployee($cod)
{
    session_start();
    $_SESSION['info']= 'Datos Borrados!';
    $_SESSION['msj']= "El empleado ha sido eliminado correctamente";

    $db = getDatabase();
    $statement = $db->prepare("DELETE FROM employees WHERE cod = ?");
    return $statement->execute([$cod]);
}

function updateEmployee($cod, $name, $last_name, $dni, $type_contract, $date_birth, $home)
{
    session_start();
    $_SESSION['info']= 'Datos Actualizados!';
    $_SESSION['msj']= "El empleado se actualizado de manera correcta";
    
    $db = getDatabase();   
    $datebirth = date("Y-m-d"); 
    $query = "UPDATE employees SET cod = ?, name = ?, last_name = ?, dni = ?,type_contract = ?, date_birth = ?, home = ? WHERE cod = ?";
    $statement = $db->prepare($query);
    return $statement->execute([$cod, $name, $last_name, $dni, $type_contract, $date_birth, $home, $cod]);
}
function getEmployeeById($cod)
{
    $db = getDatabase();
    $statement = $db->prepare("SELECT cod, name, last_name, dni, type_contract, type_contract, date_birth, home  FROM employees WHERE cod = ?");
    $statement->execute([$cod]);
    return $statement->fetchObject();
}
function saveEmployee($cod, $name, $last_name, $dni, $type_contract, $date_birth, $home)
{ 

   session_start();
    $_SESSION['info']= 'Nuevo Trabajador!';
    $_SESSION['msj']= "El empleado se registro con exito";

    $datebirth = date("Y-m-d");
    $query = "INSERT INTO employees(`cod`, `name`, `last_name`, `dni`, `type_contract`, `date_birth`, `home` ) VALUES (?,?,?,?,?,?,?)";
    $db = getDatabase();
    $statement = $db->prepare($query);
    
    return $statement->execute([$cod, $name, $last_name, $dni, $type_contract, $date_birth, $home]);
}

function getEmployees()
{
    $db = getDatabase();
    $statement = $db->query("SELECT `cod`, `name`, `last_name`, `dni`, `type_contract`, `date_birth`, `home`  FROM employees");
    return $statement->fetchAll();
}

function getVarFromEnvironmentVariables($key)
{
    if (defined("_ENV_CACHE")) {
        $vars = _ENV_CACHE;
    } else {
        $file = "env.php";
        if (!file_exists($file)) {
            throw new Exception("The environment file ($file) does not exists. Please create it");
        }
        $vars = parse_ini_file($file);
        define("_ENV_CACHE", $vars);
    }
    if (isset($vars[$key])) {
        return $vars[$key];
    } else {
        throw new Exception("The specified key (" . $key . ") does not exist in the environment file");
    }
}

function getDatabase()
{
    $password = getVarFromEnvironmentVariables("MYSQL_PASSWORD");
    $user = getVarFromEnvironmentVariables("MYSQL_USER");
    $dbName = getVarFromEnvironmentVariables("MYSQL_DATABASE_NAME");
    $database = new PDO('mysql:host=localhost;dbname=' . $dbName, $user, $password);
    $database->query("set names utf8;");
    $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $database;
}


if (!defined("RFID_STATUS_FILE")) {
    define("RFID_STATUS_FILE", "rfid_status");
}
if (!defined("RFID_STATUS_READING")) {
    define("RFID_STATUS_READING", "r");
}
if (!defined("RFID_STATUS_PAIRING")) {
    define("RFID_STATUS_PAIRING", "p");
}
if (!defined("PAIRING_EMPLOYEE_ID_FILE")) {
    define("PAIRING_EMPLOYEE_ID_FILE", "pairing_employee_id_file");
}

function getEmployeesWithRfid()
{
    $query = "SELECT employee_id, rfid_serial FROM employee_rfid";
    $db = getDatabase();
    $statement = $db->query($query);
    return $statement->fetchAll();
}

function onRfidSerialRead($rfidSerial)
{
    if (getReaderStatus() === RFID_STATUS_PAIRING) {
        pairEmployeeWithRfid($rfidSerial, getPairingEmployeeId());
        setReaderStatus(RFID_STATUS_READING);
    } else {
        $employee = getEmployeeByRfidSerial($rfidSerial);
        if ($employee) {
            saveEmployeeAttendance($employee->id);
        }
    }
}
function deleteEmployeeAttendanceByIdAndDate($employeeId, $date)
{

    $query = "DELETE FROM employee_attendance where employee_id = ? and date = ?";
    $db = getDatabase();
    $statement = $db->prepare($query);
    return $statement->execute([$employeeId, $date]);
}

function saveEmployeeAttendance($employeeId)
{
    $date = date("Y-m-d");
    deleteEmployeeAttendanceByIdAndDate($date, $employeeId);
    $status = "presence";
    $query = "INSERT INTO employee_attendance(employee_id, date, status) VALUES (?, ?, ?)";
    $db = getDatabase();
    $statement = $db->prepare($query);
    return $statement->execute([$employeeId, $date, $status]);
}

function setReaderForEmployeePairing($employeeId)
{
    setReaderStatus(RFID_STATUS_PAIRING);
    setPairingEmployeeId($employeeId);
}

function setPairingEmployeeId($employeeId)
{
    file_put_contents(PAIRING_EMPLOYEE_ID_FILE, $employeeId);
}

function getPairingEmployeeId()
{
    return file_get_contents(PAIRING_EMPLOYEE_ID_FILE);
}

function pairEmployeeWithRfid($rfidSerial, $employeeId)
{
    removeRfidFromEmployee($rfidSerial);
    $query = "INSERT INTO employee_rfid(employee_id, rfid_serial) VALUES (?, ?)";
    $db = getDatabase();
    $statement = $db->prepare($query);
    return $statement->execute([$employeeId, $rfidSerial]);
}

function removeRfidFromEmployee($rfidSerial)
{
    $query = "DELETE FROM employee_rfid WHERE rfid_serial = ?";
    $db = getDatabase();
    $statement = $db->prepare($query);
    return $statement->execute([$rfidSerial]);
}

function getEmployeeByRfidSerial($rfidSerial)
{
    $query = "SELECT e.id, e.name FROM employees e INNER JOIN employee_rfid
    ON employee_rfid.employee_id = e.id
    WHERE employee_rfid.rfid_serial = ?";

    $db = getDatabase();
    $statement = $db->prepare($query);
    $statement->execute([$rfidSerial]);
    return $statement->fetchObject();
}
function getEmployeeRfidById($employeeId)
{
    $query = "SELECT rfid_serial FROM employee_rfid WHERE employee_id = ?";
    $db = getDatabase();
    $statement = $db->prepare($query);
    $statement->execute([$employeeId]);
    return $statement->fetchObject();
}

function getReaderStatus()
{
    return file_get_contents(RFID_STATUS_FILE);
}

function setReaderStatus($newStatus)
{
    if (!in_array($newStatus, [RFID_STATUS_PAIRING, RFID_STATUS_READING])) {
        return;
    }

    file_put_contents(RFID_STATUS_FILE, $newStatus);
}

