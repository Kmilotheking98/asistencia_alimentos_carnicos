<?php
function getEmployeesWithAttendanceCount($start, $end)
{
    $query = "select employees.name, 
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
    deleteAttendanceDataByDate($date);
    $db = getDatabase();
    $db->beginTransaction();
    $statement = $db->prepare("INSERT INTO employee_attendance(employee_id, date, status) VALUES (?, ?, ?)");
    foreach ($employees as $employee) {
        $statement->execute([$employee->cod, $date, $employee->status]);
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
    $statement = $db->prepare("SELECT employee_id, status FROM employee_attendance WHERE date = ?");
    $statement->execute([$date]);
    return $statement->fetchAll();
}

function deleteEmployee($cod)
{
    $db = getDatabase();
    $statement = $db->prepare("DELETE FROM employees WHERE cod = ?");
    return $statement->execute([$cod]);
}

function updateEmployee($cod, $name, $last_name, $dni, $date_birth, $home)
{
    $db = getDatabase();   
    $datebirth = date("Y-m-d"); 
    $query = "UPDATE employees SET cod = ?, name = ?, last_name = ?, dni = ?, date_birth = ?, home = ? WHERE cod = ?";
    $statement = $db->prepare($query);
    return $statement->execute([$cod, $name, $last_name, $dni, $date_birth, $home, $cod]);
}
function getEmployeeById($cod)
{
    $db = getDatabase();
    $statement = $db->prepare("SELECT cod, name, last_name, dni, date_birth, home  FROM employees WHERE cod = ?");
    $statement->execute([$cod]);
    return $statement->fetchObject();
}
function saveEmployee($cod, $name, $last_name, $dni, $date_birth, $home)
{ 
   
    $datebirth = date("Y-m-d");
    $query = "INSERT INTO employees(`cod`, `name`, `last_name`, `dni`, `date_birth`, `home` ) VALUES (?,?,?,?,?,?)";
    $db = getDatabase();
    $statement = $db->prepare($query);
    return $statement->execute([$cod, $name, $last_name, $dni, $date_birth, $home]);
}

function getEmployees()
{
    $db = getDatabase();
    $statement = $db->query("SELECT `cod`, `name`, `last_name`, `dni`, `date_birth`, `home`  FROM employees");
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
