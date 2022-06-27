<?php
include_once "header.php";
include_once "nav.php";
include("conexion.php");

?>
<div class="row" id="app">
    <div class="col-12">
        <h1 class="text-center">RFID Pairing</h1>
    </div>
    <div>
        <form action="buscar_rfid.php" method="post">
            <input type="text" name="buscar" id="">
            <input type="submit" value="Search">

        </form>
    </div>
    <div class="col-12">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        Employee
                    </th>
                    <th>
                        RFID serial
                    </th>
                    <th>
                        Actions
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
            while($employees=mysqli_fetch_row($result)){ ?>
            
   
            <tbody>
                <tr v-for="employee in employees">
                    <td>{{employee.name}}</td>
                    <td>

                        <h4 v-if="employee.rfid_serial"><span class="badge badge-success"><i class="fa fa-check"></i>&nbsp;Assigned ({{employee.rfid_serial}})</span></h4>
                        <h4 v-else-if="employee.waiting"><span class="badge badge-warning"><i class="fa fa-clock"></i>&nbsp;Waiting... Please read a RFID card</span></h4>
                        <h4 v-else><span class="badge badge-primary"><i class="fa fa-times"></i>&nbsp;Not assigned</span></h4>
                    </td>
                    <td>
                        <button @click="removeRfidCard(employee.rfid_serial)" v-if="employee.rfid_serial" class="btn btn-danger">Remove</button>
                        <button v-else-if="employee.waiting" @click="cancelWaitingForPairing" class="btn btn-warning">Cancel</button>
                        <button @click="assignRfidCard(employee)" v-else class="btn btn-info">Assign</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>
<?php     }}
?>



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
                const employeeId = employee.id;
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
                    employeeDictionary[employee.id] = index;
                    return {
                        id: employee.id,
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
include_once "footer.php";