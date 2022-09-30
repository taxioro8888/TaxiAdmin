
<!-- Nom &amp; Prénom: WOUMTANA P. Youssouf
            Téléphone: +226 63 86 22 46 / 73 35 41 41
                Email: issoufwoumtana@gmail.com -->
<?php
    if(isset($_COOKIE['lang'])) {
        switch($_COOKIE['lang']){
            case 'bn' : include("lang/bn.php"); break;
            case 'cn' : include("lang/cn.php"); break;
            case 'de' : include("lang/de.php"); break;
            case 'en' : include("lang/en.php"); break;
            case 'esp' : include("lang/esp.php"); break;
            case 'fr' : include("lang/fr.php"); break;
            case 'in' : include("lang/in.php"); break;
            case 'jp' : include("lang/jp.php"); break;
            case 'ko' : include("lang/ko.php"); break;
            case 'pt' : include("lang/pt.php"); break;
            case 'ru' : include("lang/ru.php"); break;
            default : include("lang/sa.php"); break;
        }
    }else{
        include("lang/en.php");
    }
    include("query/fonction.php");
    $tab_infos_user[] = array();
    $id_user = "";
    if(!isset($_SESSION['user_info']) && count($_SESSION['user_info']) == 0)
        header('Location: login.php');
    else{
        $tab_infos_user = $_SESSION['user_info'];
        $id_user = $tab_infos_user['id'];
    }
    if(!(isset($_GET['id_conducteur']) && !empty($_GET['id_conducteur']))){
        header('Location: conducteur.php');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title><?php echo $title; ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <?php include('header.php') ?>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <?php include("menu.php"); ?>
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><?php echo $driver_detail; ?></h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="homex.php"><?php echo $home; ?></a></li>
                        <li class="breadcrumb-item"><?php echo $driver; ?></li>
                        <li class="breadcrumb-item active"><?php echo $driver_detail; ?></li>
                    </ol>
                </div>
                <div>
                    <!-- <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button> -->
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <?php 
                                    /* Récuperation des informations d'un conducteur */
                                    $tab_driver_info[0][] = array();
                                    $tab_driver_info = getConducteurById($_GET['id_conducteur']);
                                    $tab_driver_vehicle_info[] = array();
                                    $tab_driver_vehicle_info = getVehiculeByDriverId($_GET['id_conducteur']);
                                    $tab_service_quest[] = array();
                                ?>
                                <h4 class="card-title"><?php echo $driver_details_of; ?> <?php if(count($tab_driver_info) != 0) echo $tab_driver_info[0]['nom'].' '.$tab_driver_info[0]['prenom']; ?></h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="user-profile" style="width:100%;">
                                            <div class="profile-img" style="width:20%;">
                                                <img class="profile-pic" src="on_demand_taxi_webservice/images/app_user/<?php echo $tab_driver_info[0]['photo_path']; ?>" alt="user" style="width:300px;height:300px;"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h5><?php echo $information; ?></h5>
                                <div class="row">
                                    <!-- <div class="col-md-12">
                                        <label for="" class="label-detail-title">NIC :</label> <?php echo $tab_driver_info[0]['cnib']; ?>
                                    </div> -->
                                    <div class="col-md-12">
                                        <label for="" class="label-detail-title"><?php echo $phone; ?> :</label> <?php echo $tab_driver_info[0]['phone']; ?>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="" class="label-detail-title"><?php echo $email; ?> :</label> <?php echo $tab_driver_info[0]['email']; ?>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="" class="label-detail-title"><?php echo $status; ?> :</label> <span class="<?php if($tab_driver_info[0]['statut'] == "yes"){echo "badge badge-success";}else{echo "badge badge-danger";} ?>"><?php if($tab_driver_info[0]['statut'] == "yes"){echo "Enabled";}else{echo "Disabled";} ?></span>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="" class="label-detail-title"><?php echo $online; ?> :</label> <?php echo $tab_driver_info[0]['online']; ?>
                                    </div>
                                    <!-- <div class="col-md-12">
                                        <label for="" class="label-detail-title">Photo :</label> <?php echo $tab_driver_info[0]['photo_path']; ?>
                                    </div> -->
                                    <div class="col-md-12">
                                        <label for="" class="label-detail-title"><?php echo $created; ?> :</label> <?php echo $tab_driver_info[0]['creer']; ?>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="" class="label-detail-title"><?php echo $edited; ?> :</label> <?php echo $tab_driver_info[0]['modifier']; ?>
                                    </div>
                                    <div class="col-md-12">
                                        <table>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="" class="label-detail-title"><?php echo $licence; ?> :</label>
                                                </td>
                                                <td>
                                                    <img class="m-l-40 p-10" src="on_demand_taxi_webservice/images/app_user/<?php echo $tab_driver_info[0]['photo_licence_path']; ?>" alt="" width="50%">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="" class="label-detail-title"><?php echo $nic; ?> :</label>
                                                </td>
                                                <td>
                                                    <img class="m-l-40 p-10" src="on_demand_taxi_webservice/images/app_user/<?php echo $tab_driver_info[0]['photo_nic_path']; ?>" alt="" width="50%">
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <h5 class="m-t-20"><?php echo $vehicle_info; ?></h5>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="label-detail-title"><?php echo $brand; ?> :</label> <?php echo $tab_driver_vehicle_info[0]['brand']; ?>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="" class="label-detail-title"><?php echo $model; ?> :</label> <?php echo $tab_driver_vehicle_info[0]['model']; ?>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="" class="label-detail-title"><?php echo $color; ?> :</label> <?php echo $tab_driver_vehicle_info[0]['color']; ?>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="" class="label-detail-title"><?php echo $numberplate; ?> :</label> <?php echo $tab_driver_vehicle_info[0]['numberplate']; ?>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="" class="label-detail-title"><?php echo $number_of_passenger; ?> :</label> <?php echo $tab_driver_vehicle_info[0]['passenger']; ?>
                                    </div>
                                    <div class="col-md-12">
                                        <a href="query/action.php?id_conducteur_activer=<?php echo $_GET['id_conducteur']; ?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-original-title="Activar"> <?php echo $enable_account; ?> <i class="fa fa-check"></i> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default" class="default-theme">1</a></li>
                                <li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" data-theme="red" class="red-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme working">4</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
                                <li class="d-block m-t-30"><b>With Dark sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme">7</a></li>
                                <li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a></li>
                                <li><a href="javascript:void(0)" data-theme="red-dark" class="red-dark-theme">9</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme">10</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna-dark" class="megna-dark-theme ">12</a></li>
                            </ul>
                            <ul class="m-t-20 chatonline">
                                <li><b>Chat option</b></li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/1.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/2.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/3.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/4.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/5.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/6.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/7.jpg" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/8.jpg" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer"> <?php include("footer.php"); ?> </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>

    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>
    <!-- This is data table -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function() {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });
        });
    });
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
    });
    $('#example24').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
    });
    </script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

    
    <!--Custom JavaScript -->
    <!-- <script src="js/custom.min.js"></script> -->
    <script src="assets/plugins/toast-master/js/jquery.toast.js"></script>
    <script src="js/toastr.js"></script>
    <!-- Custom Theme JavaScript -->

    <?php if(isset($_SESSION['status']) &&  $_SESSION['status'] == 1){ ?>
            <script>
                showSuccess();
            </script>
    <?php }else if(isset($_SESSION['status']) &&  $_SESSION['status'] == 2){ ?>
            <script>
                showFailed();
            </script>
    <?php }else if(isset($_SESSION['status']) &&  $_SESSION['status'] == 3){ ?>
            <script>
                showWarningIncorrect();
            </script>
    <?php } unset($_SESSION['status']); ?>
</body>

</html>
