<?php
if (!isset($_GET["cod"])) exit("No id provided");
include_once "slidernavbar.php";
include_once "header.php";
$cod = $_GET["cod"];
include_once "functions.php";
$employee = getEmployeeById($cod);
?>


<section class="home">
    <div class="container cont__me employees__content">

    <div class="">
        <form action="employee_update.php" method="POST">
            <input type="hidden" name="cod" value="<?php echo $employee->cod ?>">
            <div class="form-group">
                <label for="name">cod</label>
                <input value="<?php echo $employee->cod ?>" name="cod" placeholder="Employee id" type="number" id="cod" class="form-control" required>
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

    </div>

</section>

    
<?php
