<?php
include_once "slidernavbar.php";
include_once "header.php";

if(!isset($_SESSION['user'])){
    header("Location: login.php");
}

if ($_SESSION['permit'] == 3) {
    header("Location: employees.php");
}


?>
    <div class="employees-home " id="app">
        <div class="col-12">
              <h1 class="text-left">ASISTENCIAS</h1>
        </div>
    <div class="col-12">
        <div class="form-inline mb-2">
            <label for="date">FECHA: &nbsp;</label>
            <input @change="refreshEmployeesList" v-model="date" name="date" id="date" type="date" class="form-control">
            <button @click="save" class="btn btn-success ml-2">Guardar</button>
        </div>
        <div>

            <input type="search" class="form-control" placeholder="Buscar por codigo del empleado" 
            v-model="search" @keyup="fetchData()" />
     
        </div>

    </div>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table">
                <thead class="text-center">
                    <tr>
                    <th>
                            CODIGO
                        </th>
                        <th>
                            EMPLEADO
                        </th>
                        <th>
                            PUESTO
                        </th>
                        <th>
                            ESTADO
                        </th>
                        <th>
                            EVENTO
                        </th>
                        <th>
                            TURNO
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="employee in employees">
                    <td class="text-center">{{employee.cod}}</td>
                        <td class="text-center">{{employee.name}}</td>
                        <td>
                            <select v-model="employee.job" class="form-control">
                                <option disabled value="unset">--seleccionar--</option>
                                <option value="Cajero">Cajero</option>
                                <option value="Vendedor">Vendedor</option>
                            </select>
                        </td>
                        <td>
                            <select v-model="employee.status" class="form-control">
                                <option disabled value="unset">--seleccionar--</option>
                                <option value="presence">Asistencia</option>
                                <option value="absence">Ausencia</option>
                            </select>
                        </td>
                        <td>
                            <select v-model="employee.status_event" class="form-control">
                                <option disabled value="unset">--seleccionar--</option>
                                <option value="si">Si</option>
                                <option value="no">No</option>
                            </select>
                        </td>
                        <td>
                            <select v-model="employee.turn" class="form-control">
                                <option disabled value="unset">--seleccionar--</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                            </select>
                        </td>
                    </tr>
                    <tr v-if="nodata">
                                <td colspan="2" align="center">No Data Found</td>
                            </tr>
                </tbody>
            </table>
        </div>          
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
                                            <button href="#" class="btn btn-success" style="width:100%" onclick="GuardarExcel_attendaces()" disabled id="btn_guardar" >Guardar Excel</button><br>   
                                        </div>                                            
                                </div>
                        </form>
                </div>
            <div  id="div_table"><br>
                                Aqui se cargaran los datos en forma de tabla para poderlos importar
            </div>
</div>

</div>
<script src="js/vue.min.js"></script>
<script src="js/vue-toasted.min.js"></script>
<script>
    Vue.use(Toasted);
    const UNSET_STATUS = "unset";
    new Vue({
        el: "#app",
        data: {
            employees: [],
            date: "",

            search:'',
            nodata:false

        },
        async mounted() {
            this.date = this.getTodaysDate();
            await this.refreshEmployeesList();
        },
        methods: {
            getTodaysDate() {
                const date = new Date();
                const month = date.getMonth() + 1;
                const day = date.getDate();
                return `${date.getFullYear()}-${(month < 10 ? '0' : '').concat(month)}-${(day < 10 ? '0' : '').concat(day)}`;
            },
            async save() {
                // We only need id and status, nothing more
                let employeesMapped = this.employees.map(employee => {
                    return {
                        cod: employee.cod,
                        job: employee.job,
                        status: employee.status,
                        status_event: employee.status_event,
                        turn: employee.turn,
                    }
                });
                // And we need only where status is set
                employeesMapped = employeesMapped.filter(employee => employee.status != UNSET_STATUS);
                const payload = {
                    date: this.date,
                    employees: employeesMapped,
                };
                const response = await fetch("./save_attendance_data.php", {
                    method: "POST",
                    body: JSON.stringify(payload),
                });
                this.$toasted.show("Guardado",{
                    position: "top-left",
                    duration: 1000,
                },
                    Swal.fire(
                        'Datos Registrados!',
                        'Guardado!',
                        'success',
                              )
                );
                
            },
            async refreshEmployeesList() {
                // Get all employees
                let response = await fetch("./get_employees_ajax.php");
                let employees = await response.json();
                // Set default status: unset
                let employeeDictionary = {};
                employees = employees.map((employee, index) => {
                    employeeDictionary[employee.cod] = index;
                    return {
                        cod: employee.cod,
                        name: employee.name,
                        job: UNSET_STATUS,
                        status: UNSET_STATUS,
                        status_event: UNSET_STATUS,
                        turn: UNSET_STATUS,
                    }
                });
                // Get attendance data, if any
                response = await fetch(`./get_attendance_data_ajax.php?date=${this.date}`);
                let attendanceData = await response.json();
                // Refresh attendance data in each employee, if any
                attendanceData.forEach(attendanceDetail => {
                    let employeeId = attendanceDetail.employee_id;
                    if (employeeId in employeeDictionary) {
                        let index = employeeDictionary[employeeId];
                        employees[index].job = attendanceDetail.job;
                        employees[index].status = attendanceDetail.status;
                        employees[index].status_event = attendanceDetail.status_event;
                        employees[index].turn = attendanceDetail.turn;
                        
                    }
                });
                // Let Vue do its magic ;)
                this.employees = employees;
            },
            fetchData:function(){
         axios.post('./action_attendance_register.php', {
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
        this.fetchData();    }
    });
</script>
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
                url: "importar_excel_ajax_attendance.php",
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

        function GuardarExcel_attendaces(){
            var contador =0;
            var arreglo_employee_id = new Array();
            var arreglo_date = new Array();
            var arreglo_job = new Array();
            var arreglo_status = new Array();
            var arreglo_status_event = new Array();
            var arreglo_turn = new Array();
            var arreglo_home = new Array();

            
            $("#tabla_detalle tbody#tbody_tabla_detalle tr").each(function(){
                
                arreglo_employee_id.push($(this).find('td').eq(0).text());
                arreglo_date.push($(this).find('td').eq(1).text());
                arreglo_job.push($(this).find('td').eq(2).text());
                arreglo_status.push($(this).find('td').eq(3).text());
                arreglo_status_event.push($(this).find('td').eq(4).text());
                arreglo_turn.push($(this).find('td').eq(5).text());
                contador++;
                
            });  
            //alert(contador);
            if(contador==0){
                return  Swal.fire("Mensaje De Advertencia","La tabla de Excel debe tener como minimo 1 dato... : ","warning");
            };
                //alert(arreglo_employee_id+" .... "+arreglo_date);
            var employee_id = arreglo_employee_id.toString();
            var date = arreglo_date.toString();
            var job =arreglo_job.toString();
            var status = arreglo_status.toString();
            var status_event = arreglo_status_event.toString();
            var turn= arreglo_type_contract.toString();

                //alert(employee_id+" .... "+last_date);
            $.ajax({
                url: "control_register_attendance.php",
                type: 'post',
                data: {
                    emp_id:employee_id,
                    d: date,
                    j: job,
                    st:status,
                    st_ev:status_event ,
                    turno: turn
                }

            }).done(function(resp){
                alert(resp);
            });



            }

        
 
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.10/vue.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script> -->
<script src="https://unpkg.com/axios/dist/axios.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</div>

