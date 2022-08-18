<?php
include_once "slidernavbar.php";
include_once "header.php";
include("conexion.php");

if ($_SESSION['permit'] == 2) {
    header("Location: attendance_report.php");
}

?>
<section class="employees-home ">

<div class="container cont__me employees__content" id="app">
    <div class="col-12">
        <h1 class="text-center">EMPAREJAR  RFID</h1>
    </div>
    <div>
    <form class='d-flex' action="buscar_rfid.php" method="post">
            <input style="width: 340px;" placeholder="¿Qué deceas buscar?" class="form-control me-3" type="text" name="buscar" id="Buscar">
            <input class="btn btn__me" type='submit'  value="Buscar">

        </form>
    </div>
    <div class="col-12">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        EMPLEADOS
                    </th>
                    <th>
                       CODIGO RFID 
                    </th>
                    <th>
                        ACCIONES
                    </th>
                </tr>
            </thead>
 <?php
          $aKeyword= explode(" ", $_POST['buscar']);

          $query ="SELECT * FROM employee_rfid WHERE  employee_id  LIKE LOWER('%".$aKeyword[0]."%') OR rfid_serial LIKE LOWER('%".$aKeyword[0]."%')";
          for($i = 1; $i < count($aKeyword); $i++) {
             if(!empty($aKeyword[$i])) {
                 $query .= " OR  employee_id  LIKE '%" . $aKeyword[$i] . "%' OR rfid_serial LIKE '%" . $aKeyword[$i] . "%'";
             }
           }
          
          $result = $conexion->query($query);
          $numero = mysqli_num_rows($result);
          if( mysqli_num_rows($result) > 0 AND $_POST['buscar'] != '') {
            while($employee=mysqli_fetch_row($result)){ ?>

        <tbody>
            <tr v-for="employee in employees">
                        <td>{{employee.name}}</td>
                        <td>

                            <h4 v-if="employee.rfid_serial" class="btn btn-success"><span ><i class="fa fa-check"></i>&nbsp;Asignado ({{employee.rfid_serial}})</span></h4>
                            <h4 v-else-if="employee.waiting" class="btn btn-warning"><span ><i class="fa fa-clock"></i>&nbsp;Esperando... por favor pasa la tarjeta RFID </span></h4>
                            <h4 v-else><span class="btn btn-info"><i class="fa fa-times"></i>&nbsp;No registrado</span></h4>
                        </td>
                        <td>
                            <button @click="removeRfidCard(employee.rfid_serial)" v-if="employee.rfid_serial" class="btn btn-danger">Remover</button>
                            <button v-else-if="employee.waiting" @click="cancelWaitingForPairing" class="btn btn-warning">Cancelar</button>
                            <button @click="assignRfidCard(employee)" v-else class="btn btn-info">Asignar</button>
                        </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>
</section>
<?php     }}
?>




<script src="js/vue.min.js"></script>
<script src="js/vue-toasted.min.js"></script>
<script>
    Vue.use(Toasted);
    let shouldCheck = true;
    const CHECK_PAIRING_EMPLOYEE_INTERVAL = 1000;
function findById(items,employee_id){
    for($i in items){
        if(items[i].id == employee_id){
            return items[i];
        }
    }
    return null;
}     
    new Vue({
        el: "#app",
        data: () => ({
            employees: [],
            date: "",
        }),
        async mounted() {
            await this.setReaderForReading();
            await this.refreshEmployeesList();
        },
        methods: {
            async removeRfidCard(rfidSerial) {
                await fetch("./remove_rfid_card.php?rfid_serial=" + rfidSerial);
                this.$toasted.show("RFID removed", {
                    position: "top-left",
                    duration: 1000,
                });
                await this.refreshEmployeesList();
            },
            async cancelWaitingForPairing() {
                shouldCheck = false;
                await this.setReaderForReading();
            },
            async setReaderForReading() {
                await fetch("./set_reader_for_reading.php");
            },
            async assignRfidCard(employee) {
                shouldCheck = true;
                const employeeId = employee.cod;
                employee.waiting = true;
                await fetch("./set_reader_for_pairing.php?employee_id=" + employeeId);
                this.checkIfEmployeeHasJustAssignedRfid(employee);
            },
            async checkIfEmployeeHasJustAssignedRfid(employee) {
                const r = await fetch("./get_employee_rfid_serial_by_id.php?employee_id=" + employee.id);
                const serial = await r.json();
                if (!shouldCheck) {
                    employee.waiting = false;
                    return;
                }
                if (serial) {
                    this.$toasted.show("RFID assigned!", {
                        position: "top-left",
                        duration: 1000,
                    });
                    await this.setReaderForReading();
                    await this.refreshEmployeesList();
                } else {
                    setTimeout(() => {
                        this.checkIfEmployeeHasJustAssignedRfid(employee);
                    }, CHECK_PAIRING_EMPLOYEE_INTERVAL);
                }
            },
            async refreshEmployeesList() {
                // Get all employees
                let response = await fetch("./get_employees_ajax.php");
                let employees = await response.json();
                // Set rfid_serial by default: null
                let employeeDictionary = {};
                employees = employees.map((employee, index) => {
                    employeeDictionary[employee.cod] = index;
                    return {
                        code: employee.code,
                        name: employee.name,
                        rfid_serial: null,
                        waiting: false,
                    }
                });
                // Get RFID data, if any
                response = await fetch(`./get_employees_with_rfid.php`);
                let rfidData = await response.json();
                // Refresh rfid data in each employee, if any
                rfidData.forEach(rfidDetail => {
                    let employeeId = rfidDetail.employee_id;
                    if (employeeId in employeeDictionary) {
                        let index = employeeDictionary[employeeId];
                        employees[index].rfid_serial = rfidDetail.rfid_serial;
                    }
                });
                // Let Vue do its magic ;)
                this.employees = employees;
            }
        },
    });
</script>
<?php
