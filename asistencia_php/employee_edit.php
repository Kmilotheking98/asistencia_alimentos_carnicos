<?php
if (!isset($_GET["employee_id"])) exit("No id provided");
include_once "header.php";
include_once "nav.php";
$employee_id = $_GET["employee_id"];
include_once "functions.php";
$employee = getEmployeeById($employee_id);
?>
<div class="row">
    <div class="col-12">
        <h1 class="text-center">Edit employee</h1>
    </div>
    <div class="col-12">
        <form action="employee_update.php" method="POST">
            <input type="hidden" name="employee_id" value="<?php echo $employee->employee_id ?>">
            <div class="form-group">
                <label for="name">employee_id</label>
                <input value="<?php echo $employee->employee_id ?>" name="employee_id" placeholder="Employee id" type="number" id="employee_id" class="form-control" required>
                <label for="name">Name</label>
                <input value="<?php echo $employee->name ?>" name="name" placeholder="Name" type="text" id="name" class="form-control" required>
                <label for="name">Last Name</label>
                <input value="<?php echo $employee->last_name ?>" name="last_name" placeholder="Last Name" type="text" id="last_name" class="form-control" required>                
                <label for="name">DNI</label>
                <input value="<?php echo $employee->dni ?>" name="dni" placeholder="DNI" type="number" id="dni" class="form-control" required>
                <label for="name">Date Birth</label>
                <input value="<?php echo $employee->date_birth?>" name="date_birth" placeholder="Date Birth" type="text" id="date_birth" class="form-control" required>
                <label for="name">Home</label>
                <input value="<?php echo $employee->home ?>" name="home" placeholder="Home" type="text" id="home" class="form-control" required>
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