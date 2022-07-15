<?php
include_once "header.php";
include_once "nav.php";
include_once "functions.php";
$employees = getEmployees();
include("conexion.php");
?>



<div class="row">
    <div class="col-12">
        <h1 class="text-center">Employees</h1>
    </div>
    <div class="col-12">
        <a href="employee_add.php" class="btn btn-info mb-2">Add new employee <i class="fa fa-plus"></i></a>

    </div>
    

    <div>
        <form action="buscar_employee.php" method="post">
            <input type="text" name="buscar" id="">
            <input type="submit" value="Search">

        </form>
    </div>
    <div class="col-12">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>last Name</th>
                        <th>DNI</th>
                        <th>Date Birth</th>
                        <th>Home</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employees as $employee) { ?>
                        <tr>
                            <td>
                                <?php echo $employee->cod ?>
                            </td>
                            <td>
                                <?php echo $employee->name ?>
                            </td>
                            <td>
                                <?php echo $employee->last_name ?>
                            </td>
                            <td>
                                <?php echo $employee->dni ?>
                            </td>
                            <td>
                                <?php echo $employee->date_birth ?>
                            </td>
                            <td>
                                <?php echo $employee->home ?>
                            </td>
                            
                            <td>
                                <a class="btn btn-warning" href="employee_edit.php? cod=<?php echo $employee->cod ?>">
                                Edit <i class="fa fa-edit"></i>
                            </a>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="employee_delete.php?cod=<?php echo $employee->cod ?>">
                                Delete <i class="fa fa-trash"></i>
                            </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>











<?php
include_once "footer.php";