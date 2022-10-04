


<?php
 //Conexion
 require "conexion.php";


$received_data = json_decode(file_get_contents("php://input"));

$data = array();

if($received_data->search != '')
{
	$search = "
	SELECT * FROM employee_rfid
	WHERE employee_id LIKE '%".$received_data->search."%' 
	OR rfid_serial LIKE '%".$received_data->search."%' 
	ORDER BY employee_id 
	";
}
else
{
	$search = "
	SELECT * FROM employee_rfid`
	ORDER BY employee_id  
	";
}

$statement = $conn->prepare($search);

$statement->execute();

while($employee = $statement->fetch(PDO::FETCH_ASSOC))
{
	$data[] = $employee;
}

echo json_encode($data);

?>