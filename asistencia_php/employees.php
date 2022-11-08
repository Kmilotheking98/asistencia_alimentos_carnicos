<?php
session_start();
include_once "slidernavbar.php";
include_once "header.php";
include_once "functions.php";
$employees = getEmployees();
include("conexion.php");

if (isset($_SESSION['user'])) {
    if ($_SESSION['permit'] == 2) {
        header("Location: attendance_report.php");
    }

}else{
    header('Location: login.php');
}
?>


<!DOCTYPE html>

<body>

    <div class="employees-home ">
        <div class="col-12">
              <h1 class="text-left">EMPLEADOS</h1>
        </div>
        <div class="barra-top">
            <div class="container-barra  bd-highlight">
                <div class="barra-buscar-container p-2 bd-highlight">

                    <form class='d-flex' action="buscar_employee.php" method="post">
                        <input placeholder="¿Qué deceas buscar?" class="form-control me-3" type="search" name="buscar"
                            id="">
                        <input class="btn btn__me" type='submit' value="Buscar"></input>
                    </form>

                </div>
                <div class="p-2 bd-highlight">

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    
                        <a href="employee_add.php" type="button" class="btn btn-warning me-md-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor"
                                class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                <path fill-rule="evenodd"
                                    d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                            </svg>                            
                            &nbspRegistrar Empleado
                        </a>
                            <?php

                                if (isset($_SESSION['msj'])){ 
                                    $respuesta = $_SESSION['msj'];?> 
                                        <script>
                                            Swal.fire(
                                            '<?php echo $_SESSION['info']; ?>',
                                            '<?php echo $respuesta; ?>',
                                            //'REGISTRO EXITOSO',
                                            'success'
                                                    )
                                        </script>    
                                            
                                 <?php 
                                unset($_SESSION['info']);
                                unset($_SESSION['msj']);
                            } ?> 
                    </div>

                </div>
            </div>
        </div>

        <div class='table-container shadow-sm'>

        <div class="tabla__employees rounded ">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>CODIGO</th>
                            <th>NOMBRE</th>
                            <th>APELLIDOS</th>
                            <th>CEDULA</th>
                            <th>TIPO DE CONTRATO</th>
                            <th>FECHA DE NACIMIENTO</th>
                            <th>RESIDENCIA</th>
                            <th>EDITAR</th>
                            <th>ELIMINAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $employee) { ?>
                        <tr>
                            <td class="text-center">
                                <?php echo $employee->cod ?>
                            </td>
                            <td >
                                <?php echo $employee->name ?>
                            </td>
                            <td>
                                <?php echo $employee->last_name ?>
                            </td>
                            <td>
                                <?php echo $employee->dni ?>
                            </td>
                            <td>
                                <?php echo $employee->type_contract ?>
                            </td>
                            <td>
                                <?php echo $employee->date_birth ?>
                            </td>
                            <td>
                                <?php echo $employee->home ?>
                            </td>

                            <td>
                            <a class="btn btn-warning" href="employee_edit.php? cod=<?php echo $employee->cod ?>">
                                  
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg>


                                </a>
                            </td>
                            <td>

                                <a class="btn btn-danger" href="#" onclick="question(<?php echo $employee->cod ?>)">
                                    

                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg>
                                                        
                                  
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <script type="text/javascript">
                  function question(cod){

                        Swal.fire({
                            title: '¿Está seguro?',
                            text: "¡No podrás revertir esto!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#695CFE',
                            confirmButtonText: '¡Si, Borralo!',
                            cancelButtonText: '¡No, Cancelar!'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "employee_delete.php?cod="+cod;
                               
                            }
                            })
                                
                  }

                    </script> 
                  
                </table>
            </div>
                                <div class="col-lg-12">
                            <div class="card-header">
                                Importar Excel
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Agregar Registros Desde Excel</h5>
                                <p class="card-text">Por favor cargar el Excel para agregar registros en cantidad .</p>
                                    <form action="#" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <input class="form-control" type='file' id="txt_archivo" accept=".csv,.xlsx,.xls">
                                            </div>
                                            <div class="col-lg-2">
                                                <button href="#" class="btn btn__me" style="width:100%" onclick="CargarExcel()" >Cargar Excel</button><br>   
                                            </div>
                                            <div class="col-lg-2">
                                                <button href="#" class="btn btn-success" style="width:100%" onclick="GuardarExcel_employees()" disabled id="btn_guardar" >Guardar Excel</button><br>   
                                            </div>                                            
                                        </div>
                                    </form>
                                </div>
                            <div  id="div_table"><br>
                                Aqui se cargaran los datos en forma de tabla para poderlos importar
                            </div>
                    </div>
        </div>
        </div>

    </div>
</body>
<script type="text/javascript">
    $('input[type="file"]').on('change', function(){
            var ext = $( this ).val().split('.').pop();
                if ($( this ).val() != '') {
                    if(ext == "xls" || ext == "xlsx" || ext == "csv"){
                    }
                else
                {
                $( this ).val('');
                    Swal.fire("Mensaje De Error","Extensión no permitida: " + ext+"","error");
            }
            }
        });


        function CargarExcel(){
            var excel = $("#txt_archivo").val();
            if(excel === ""){
                return  Swal.fire("Mensaje De Advertencia","Seleccionar un archivo Excel: ","warning");
            }
            var formData = new FormData();
            var files = $("#txt_archivo")[0].files[0];
            formData.append('archivoexcel',files);
            $.ajax({
                url: "importar_excel_ajax_employees.php",
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                success : function(resp){
                    
                    $('#div_table').html(resp);
                    document.getElementById('btn_guardar').disabled=false;
                    return  Swal.fire("Importacion Exitosa","El Excel se Importo con exito: "+resp+"","success");
                }
            }); 
            return false;

        };

        function GuardarExcel_employees(){
            var contador =0;
            var arreglo_cod = new Array();
            var arreglo_name = new Array();
            var arreglo_last_name = new Array();
            var arreglo_dni = new Array();
            var arreglo_date_birth = new Array();
            var arreglo_type_contract = new Array();
            var arreglo_home = new Array();

            
            $("#tabla_detalle tbody#tbody_tabla_detalle tr").each(function(){
                
                arreglo_cod.push($(this).find('td').eq(0).text());
                arreglo_name.push($(this).find('td').eq(1).text());
                arreglo_last_name.push($(this).find('td').eq(2).text());
                arreglo_dni.push($(this).find('td').eq(3).text());
                arreglo_date_birth.push($(this).find('td').eq(4).text());
                arreglo_type_contract.push($(this).find('td').eq(5).text());
                arreglo_home.push($(this).find('td').eq(6).text());
                contador++;
                
            });  
            //alert(contador);
            if(contador==0){
                return  Swal.fire("Mensaje De Advertencia","La tabla de Excel debe tener como minimo 1 dato... : ","warning");
            };
                //alert(arreglo_cod+" .... "+arreglo_name);
            var cod = arreglo_cod.toString();
            var name = arreglo_name.toString();
            var last_name =arreglo_last_name.toString();
            var dni = arreglo_dni.toString();
            var date_birth = arreglo_date_birth.toString();
            var type_contract= arreglo_type_contract.toString();
            var home = arreglo_home.toString();
                //alert(cod+" .... "+last_name);
            $.ajax({
                url: "control_register_employees.php",
                type: 'post',
                data: {
                    codem:cod,
                    nam: name,
                    l_name: last_name,
                    Dni:dni,
                    D_birth:date_birth ,
                    T_contract: type_contract,
                    hme:home

                }

            }).done(function(resp){
                alert(resp);
            });



            }

        
 
</script>

</html>

