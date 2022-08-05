<?php 
session_start();
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}

?>



<nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="logo.png" alt="">
                </span>

                <div class="text logo-text">
                    <span class="name">Asistencia</span>
                    <span class="profession"><?php echo $_SESSION['user']; ?></span>
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




                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="#">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>

                
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
