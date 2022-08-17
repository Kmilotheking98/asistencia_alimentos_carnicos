<?php
include_once "slidernavbar.php";
include_once "header.php";
?>

  
<section class="home">
    <div class="container cont__me employees__content">
    <div class="col-12">
        <h1 class="text-center">REGISTRAR EMPLEADOS</h1> 
            
    <form action="employee_save.php" method="POST">
            <div class="form-group">
                <label for="name">CODIGO</label>
                <input name="cod" placeholder="Codigo del empleado" type="number" id="cod" class="form-control" required >
                <label for="name">NOMBRE</label>
                <input name="name" placeholder="Nombre" type="text" id="name" class="form-control" required >
                <label for="name">APELLIDOS</label>
                <input name="last_name" placeholder="Apellidos" type="text" id="last_name" class="form-control" required >
                <label for="name">CEDULA</label>
                <input name="dni" placeholder="Cedula" type="number" id="dni" class="form-control" required >
                <label for="name">TIPO DE CONTRATO</label>
                <td>
                    <select v-model="type_contract" name="type_contract" class="form-control">
                        <option disabled value="unset">--seleccionar--</option>
                            <option value="temporal" name="temporal" id="temporal">Temporal</option>
                            <option value="indefinido" name="indefinido" id="indefinido">Indefinido</option>
                    </select>
                </td>
                <label for="date">FECHA DE NACIMIENTO &nbsp;</label>
                <input @change="refreshEmployeesList" v-model="date" name="date_birth" id="date_birth" type="date" class="form-control" required>
                <label for="name">RESIDENCIA</label>
                <input name="home" placeholder="Residencia" type="text" id="home" class="form-control" required >
            </div>
            <div class="form-group">
                <button class="btn btn-success">
                    REGISTRAR <i class="fa fa-check"></i>
                </button>
            </div>
        </form>

    </div>
</section>
<?php
