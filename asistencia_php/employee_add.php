<?php
include_once "header.php";
include_once "nav.php";
?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">Add employee</h1>
    </div>
    <div class="col-12">
        <form action="employee_save.php" method="POST">
            <div class="form-group">
                <label for="name">Employee ID</label>
                <input name="employee_id" placeholder="Employee ID" type="number" id="employee_id" class="form-control"  >
                <label for="name">Name</label>
                <input name="name" placeholder="Name" type="text" id="name" class="form-control"  >
                <label for="name">last Name</label>
                <input name="last_name" placeholder="last Name" type="text" id="last_name" class="form-control"  >
                <label for="name">DNI</label>
                <input name="dni" placeholder="DNI" type="number" id="dni" class="form-control"  >
                <label for="date">Date Birth &nbsp;</label>
                <input @change="refreshEmployeesList" v-model="date" name="date_birth" id="date_birth" type="date" class="form-control">
                <label for="name">Home</label>
                <input name="home" placeholder="Home" type="text" id="home" class="form-control"  >
            </div>
            <div class="form-group">
                <button class="btn btn-success">
                    Save <i class="fa fa-check"></i>
                </button>
            </div>
        </form>
    </div>
</div>
<?php
include_once "footer.php";