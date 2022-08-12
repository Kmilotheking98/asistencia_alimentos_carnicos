<?php
if (!isset($_GET["cod"])) exit("No id provided");
include_once "header.php";
include_once "slidernavbar.php";
$cod = $_GET["cod"];
include_once "functions.php";
$employee = getEmployeeById($cod);
// esto va conectado con el select 
include("conexion.php");
$query = mysqli_query($conexion,'SELECT type_contract FROM employees');

?>

<section class="home">
    <div class="container cont__me employees__content">
    <div class="col-12">
        <h1 class="text-center">Edit employee</h1>
    </div>
    <div class="col-12">
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
                <label for="name">Type Of Contract</label>               
                <td>
                    <select name="type_contract" value="indefinido" class="form-control">
                            <?php 
// este while recorre los datos de la base de datos
                            while($datos = mysqli_fetch_array($query)){}
                            ?>
                            <option value="<?php echo $employee->type_contract ?>"><?php echo $employee->type_contract ?></option>
                            <option value="temporal" name="temporal" id="temporal">Temporal</option>
                            <option value='indefinido' name='indefinido' id='indefinido'>Indefinido</option>

                    </select>
                </td>

                <label for="name">Date Birth</label>
                <input value="<?php echo $employee->date_birth?>" name="date_birth" placeholder="Date Birth" type="date" id="date_birth" class="form-control" required>
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
</section>
<?php