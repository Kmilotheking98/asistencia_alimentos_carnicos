<?php 
error_reporting(E_ALL ^ E_NOTICE);
session_start();

$user=$_SESSION['user'];
$permit=$_SESSION['permit'];
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}

if($permit == 1){
    $permittext = "Admin";
}elseif($permit == 2){
    $permittext = "Supervisor";
}else{
    $permittext = "Colaborador";
}
?>

<link rel="icon" type="image/png" href="logo.png">

<nav class="sidebar close">
        <header >
            <div class="image-text">
                <span class="image">
                    <img src="logo.png" alt="">
                </span>

                <div class="text logo-text">
                    <span class="name">Asistencia</span>
                    <h5 style='line-height: 0.5;' ><?php echo $permittext; ?></h5>
                    <h1 class="profession"><?php echo $user; ?></h1>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">

                <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input type="text" placeholder="Search...">
                </li> 
                <ul class="menu-links">
                <?php 
                if($permit == 1){?>


                    <li class="nav-link">
                        <a href="employees.php">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="text nav-text">Home</span>
                        </a>
                    </li>



                    <li class="nav-link">
                        <a href="employees_rfid.php">
                            <i class='bx bx-card icon'></i>
                            <span class="text nav-text">Tarjetas</span>
                        </a>
                    </li>



                    <li class="nav-link">
                        <a href="attendance_register.php">
                            <i class='bx bx-pie-chart-alt icon'></i>
                            <span class="text nav-text">Asistencias</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="attendance_report.php">
                            <i class='bx bx-bar-chart-alt-2 icon'></i>
                            <span class="text nav-text">Reportes</span>
                        </a>
                    </li>

                    <li >
                    <a href="logout.php">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>




                </ul>
                </div>

                <?php
                }else if($permit == 2){?>

                <li class="nav-link">
                        <a href="attendance_register.php">
                            <i class='bx bx-pie-chart-alt icon'></i>
                            <span class="text nav-text">Asistencias</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="attendance_report.php">
                            <i class='bx bx-bar-chart-alt-2 icon'></i>
                            <span class="text nav-text">Reportes</span>
                        </a>
                    </li>


                <?php } elseif($permit == 3)  { ?>

                    <li class="nav-link">
                        <a href="employees.php">
                            <i class='bx bx-home-alt icon'></i>
                            <span class="text nav-text">Home</span>
                        </a>
                    </li>



                    <li class="nav-link">
                        <a href="employees_rfid.php">
                            <i class='bx bx-card icon'></i>
                            <span class="text nav-text">Tarjetas</span>
                        </a>
                    </li>

                    

                <?php }?>

            <div class="bottom-content">
                <li class="mode">
                    <div class="sun-moon">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Dark mode</span>
                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>

            
            </div>
        </div>

    </nav>
