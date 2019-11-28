<link rel="stylesheet" href="">
<!-- Side Navigation -->
<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-red" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand text-white" href="#">P E F I N D O
                <!-- <img src="../assets/img/pefindo.png" class="nav-img" alt="Pefindo Logo"> -->
            </a>
            <div class="ml-auto">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                        <i class="sidenav-toggler-line"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="../pages/scoring_engine.php" class="nav-link" aria-expanded="true" aria-controls="navbar-dashboards">
                            <i class="fas fa-chart-pie text-white"></i>
                            <span class="nav-link-text text-white h4">Scoring Engine</span>
                        </a>
                    </li>

                    <?php
                        if($_SESSION['role'] == 'superadmin')
                        {
                            ?>
                                <li class="nav-item">
                                    <a href="../pages/model_list.php" class="nav-link" aria-expanded="true" aria-controls="navbar-dashboards">
                                        <i class="fas fa-edit text-white"></i>
                                        <span class="nav-link-text text-white h4">Model</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../pages/model_performance.php" class="nav-link" aria-expanded="true" aria-controls="navbar-dashboards">
                                        <i class="fas fa-running text-white"></i>
                                        <span class="nav-link-text text-white h4">Model Performance</span>
                                    </a>
                                </li>
                            <?php
                        }
                    ?>

                    <li class="nav-item">
                        <a href="../pages/settings.php" class="nav-link" aria-expanded="true" aria-controls="navbar-dashboards">
                            <i class="fa fa-wrench text-white"></i>
                            <span class="nav-link-text text-white h4">Profile Setting</span>
                        </a>
                    </li>

                    <?php
                        if($_SESSION['role'] == 'superadmin')
                        {
                            ?>
                                <li class="nav-item">
                                    <a href="../pages/user_management.php" class="nav-link" aria-expanded="true" aria-controls="navbar-dashboards">
                                        <i class="fa fa-users text-white"></i>
                                        <span class="nav-link-text text-white h4">Key User Management</span>
                                    </a>
                                </li>
                            <?php
                        }
                        else if($_SESSION['role'] == 'keyuser')
                        {
                            ?>
                                <li class="nav-item">
                                    <a href="../pages/user_management_2.php" class="nav-link" aria-expanded="true" aria-controls="navbar-dashboards">
                                        <i class="fa fa-users text-white"></i>
                                        <span class="nav-link-text text-white h4">User Management</span>
                                    </a>
                                </li>
                            <?php
                        }
                    ?>
                    <li class="nav-item">
                        <a href="../pages/monitoring.php" class="nav-link" aria-expanded="true" aria-controls="navbar-dashboards">
                            <i class="fas fa-tachometer-alt text-white"></i>
                            <span class="nav-link-text text-white h4">Server Monitoring</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>