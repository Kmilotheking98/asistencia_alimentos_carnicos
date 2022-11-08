<!-- 
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Vue.js Live Data Search with PHP & Mysql</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script> 
		<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
	</head>
	<body>
		<div class="container" id="app">
			<br />
			<h3 align="center">Vue.js Live Data Search with PHP & Mysql</h3>
			<br />
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-9">
							<h3 class="panel-title">Sample Data</h3>
						</div>
						<div class="col-md-3" align="right">
							<input type="text" class="form-control input-sm" placeholder="Search Data" v-model="search" @keyup="fetchData()" />
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<tr>
								<th>CODE</th>
								<th>SERIAL RFID</th>
							</tr>
							<tr v-for="employee in employees">
								<td>{{employee.employee_id}}</td>
								<td>{{employee.job}}</td>
								<td>{{employee.date}}</td>
								<td>{{employee.status_event}}</td>
								<td>{{employee.turn}}</td>
							</tr>
							<tr v-if="nodata">
								<td colspan="2" align="center">No Data Found</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<script>

var application = new Vue({
	el:'#app',
	data:{
		employees:[],
		search:'',
		nodata:false
	},
	methods: {
		fetchData:function(){
			axios.post('action_attendance_register.php', {
				search:this.search
			}).then(function(response){
				if(response.data.length > 0)
				{
					application.employees = response.data;
					application.nodata = false;
				}
				else
				{
					application.employees = '';
					application.nodata = true;
				}
			});
		}
	},
	created:function(){
		this.fetchData();
	}
});

</script> -->
<?php
require_once 'PHPExcel/Classes/PHPExcel.php';
require_once 'conexion.php';

$archivos = 'Documentos/pruebas.csv';
$excel = PHPExcel_IOFactory::load($archivos);

$excel-> setActiveSheetIndex(0);

$numerofila = $excel-> setActiveSheetIndex(0)->getHighestRow();

echo " <table id='tabla_detalle' class='table-responsive' style='width:100%; table-layout: fixed'>
<thead>
	<tr>
		<th>CODIGO</th>
		<th>NOMBRE</th>
		<th>APELLIDOS</th>
		<th>CEDULA</th>
		<th>TIPO DE CONTRATO</th>
		<th>FECHA DE NACIMIENTO</th>
		<th>RESIDENCIA</th>
	</tr>
</thead>
<tbody id='tbody_tabla_detalle'>";
   for($row = 2; $row <=$filas;$row++){
	$cod = $hoja -> getCell('A'.$row)->getvalue();
	$name = $hoja -> getCell('B'.$row)->getvalue();
	$last_name = $hoja -> getCell('C'.$row)->getvalue();
	$dni = $hoja -> getCell('D'.$row)->getvalue();
	$date_birth = $hoja -> getCell('E'.$row)->getvalue();
	$type_contract = $hoja -> getCell('F'.$row)->getvalue();
	$home = $hoja -> getCell('G'.$row)->getvalue();

	echo "<tr>";
	echo "<td>".$cod."</td>";
	echo "<td>".$name."</td>";
	echo "<td>".$last_name."</td>";
	echo "<td>".$dni."</td>";
	echo "<td>".$date_birth."</td>";
	echo "<td>".$type_contract."</td>";
	echo "<td>".$home."</td>";
	echo "</tr>";
   } 
   echo "</tbody></table>";


?>

