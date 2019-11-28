<?php include "../config.php"; include "../session.php"; ?>
<!doctype html>
<html lang="en">
    <head>
        <?php include "../partials/assets_css.php";?>
        <title>Server Monitoring</title>
    </head>
    <body>
        <?php include "../partials/sidenav.php";?>

        <div class="main-content" id="panel">
            <?php include "../partials/topnav.php";?>

            <!-- Header -->
            <div class="header pb-6">
                <div class="container-fluid">
                    <div class="header-body">
                        <div class="row align-items-center py-4">
                            <div class="col-lg-6 col-7">
                                <h6 class="h2 d-inline-block mb-0">Server Monitoring</h6>
                                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                                    <ol class="breadcrumb breadcrumb-links">
                                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                                        <li class="breadcrumb-item" aria-current="page"><a href="monitoring.php">Server Monitoring</a></li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-lg-6 col-5 text-right"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-fluid mt--6">
                <div class="row">
                    <div class="col-xl-12 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="embed-responsive embed-responsive-16by9">
<!--                                    <iframe class="embed-responsive-item" src="http://192.168.10.171:5601/app/kibana#/dashboard/Metricbeat-system-overview-ecs?embed=true&_g=(refreshInterval%3A(pause%3A!f%2Cvalue%3A10000)%2Ctime%3A(from%3Anow-15m%2Cto%3Anow))"></iframe>-->
<!--                                    <iframe class="embed-responsive-item" src="https://192.168.10.171:5601/goto/751b4fffd38debea7a67e2d7d6d18ddd?embed=true"></iframe>-->
                                    <iframe class="embed-responsive-item" src="https://192.168.10.171:5601/app/kibana#/dashboard/Metricbeat-system-overview-ecs?embed=true&_g=(refreshInterval%3A(pause%3A!f%2Cvalue%3A10000)%2Ctime%3A(from%3Anow-15m%2Cto%3Anow))" height="600" width="800"></iframe>
<!--                                    <iframe src="http://192.168.10.171:5601/app/kibana#/dashboard/Metricbeat-system-overview-ecs?embed=true&_g=(refreshInterval%3A(pause%3A!f%2Cvalue%3A10000)%2Ctime%3A(from%3Anow-15m%2Cto%3Anow))" height="600" width="800"></iframe>-->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php include "../partials/assets_js.php";?>
    </body>
</html>