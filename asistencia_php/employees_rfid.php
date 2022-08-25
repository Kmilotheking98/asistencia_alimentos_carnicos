<?php
include_once "slidernavbar.php";
include_once "header.php";


if ($_SESSION['permit'] == 2) {
    header("Location: attendance_report.php");
}

?>

<section class="employees-home ">
<div class="container cont__me employees__content" id="app">
    <div class="col-12">
        <h1 class="text-center">EMPAREJAMIENTO RFID</h1>
    </div>
    <!-- <div>
        <form class='d-flex' action="buscar_rfid.php" method="post">
            <input style="width: 340px;" placeholder="¿Qué deceas buscar?" class="form-control me-3" type="text" name="buscar" id="">
            <input class="btn btn__me" type='submit'  value="Buscar">

        </form>
    </div> -->
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead >
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
<script src="js/vue.min.js"></script>
<script src="js/vue-toasted.min.js"></script>
<script>
    Vue.use(Toasted);
    let shouldCheck = true;
    const CHECK_PAIRING_EMPLOYEE_INTERVAL = 1000;
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
                        cod: employee.cod,
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
