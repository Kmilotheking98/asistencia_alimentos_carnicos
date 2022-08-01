<?php
include_once "slidernavbar.php";
include_once "header.php";
?>


<section class="home">
    <div class="container cont__me employees__content">
    <div class="col-12">
        <h1 class="text-center">Register Employee</h1> 
            
    <form action="employee_save.php" method="POST">
            <div class="form-group">
                <label for="name">Employee ID</label>
                <input name="cod" placeholder="Employee ID" type="number" id="cod" class="form-control" required >
                <label for="name">Name</label>
                <input name="name" placeholder="Name" type="text" id="name" class="form-control" required >
                <label for="name">last Name</label>
                <input name="last_name" placeholder="last Name" type="text" id="last_name" class="form-control" required >
                <label for="name">DNI</label>
                <input name="dni" placeholder="DNI" type="number" id="dni" class="form-control" required >
                <label for="date">Date Birth &nbsp;</label>
                <input @change="refreshEmployeesList" v-model="date" name="date_birth" id="date_birth" type="date" class="form-control" required>
                <label for="name">Home</label>
                <input name="home" placeholder="Home" type="text" id="home" class="form-control" required >
            </div>
            <div class="form-group">
                <button class="btn btn-success">
                    Save <i class="fa fa-check"></i>
                </button>
            </div>
        </form>

    </div>
</section>
<?php
