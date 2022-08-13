<?php
include_once "header.php";
include_once "slidernavbar.php";
if ($_SESSION['permit'] ==3) {
    header("Location: employees.php");
}


?>
<section class="home">
<div class="container cont__me employees__content" id="app">
    <div class="col-12">
        <h1 class="text-center">ASISTENCIAS</h1>
    </div>
    <div class="col-12">
        <div class="form-inline mb-2">
            <label for="date">FECHA: &nbsp;</label>
            <input @change="refreshEmployeesList" v-model="date" name="date" id="date" type="date" class="form-control">
            <button @click="save" class="btn btn-success ml-2">Guardar</button>
        </div>
    </div>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
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
                    <td>{{employee.cod}}</td>
                        <td>{{employee.name}}</td>
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
    const UNSET_STATUS = "unset";
    new Vue({
        el: "#app",
        data: () => ({
            employees: [],
            date: "",
        }),
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
                this.$toasted.show("Saved", {
                    position: "top-left",
                    duration: 1000,
                });
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
            }
        },
    });
</script>
<?php

