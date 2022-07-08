<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" >
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" ></script>

<script src="../Alert/sweetalert-dev.js"></script>
<link rel="stylesheet" href="../Alert/sweetalert.css">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

 <!-- ESTILO CURSOS DE PROGRAMACION -->
 <link rel="stylesheet" href="../css/style_cp.css">

 <!-- importante -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>


<title>Consulta basica</title>
</head>
<body>


<!-- NAVBAR -->

<!-- END NAVBAR -->



<!-- buscador basico -->

<!-- END buscador basico -->
<form action="buscar.php" method="post">
<div class="center mt-5">
        <div class="card pt-3" >
                <p style="font-weight: bold; color: #0F6BB7; font-size: 22px;">Buscador Inmediato</p>
                <div class="container-fluid  p-4">
                        <div class=" col-12 mt-2">
                                <div class="table-responsive">
                                        <div class="mb-3"> 
                                                <label class="form-label">Palabra a buscar instantaneo</label>
                                                <input onkeyup="buscar_ahora($('#buscar_1').val());" type="text" class="form-control" id="buscar_1" name="buscar_1">
                                        </div>
                                        <div class="card col-12 mt-5">
                                                <div class="card-body">
                                                        <div id="datos_buscador" class="container pl-5 pr-5" style="border: none;"></div>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>
</div>
</form>
<script type="text/javascript">
        function buscar_ahora(buscar) {
        var parametros = {"buscar":buscar};
        $.ajax({
        data:parametros,
        type: 'POST',
        url: 'buscar.php',
        success: function(data) {
        document.getElementById("datos_buscador").innerHTML = data;
        }
        });
        }
      
</script>

</body>
</html>