<!-- Nom &amp; Prénom: WOUMTANA P. Youssouf
            Téléphone: +226 63 86 22 46 / 73 35 41 41
                Email: issoufwoumtana@gmail.com -->
<?php
if (isset($_COOKIE['lang'])) {
    switch ($_COOKIE['lang']) {

        case 'en':
            include("lang/en.php");
            break;
        case 'esp':
            include("lang/esp.php");
            break;

        default:
            include("lang/sa.php");
            break;
    }
} else {
    include("lang/en.php");
}
include("query/fonction.php");
include("dico.php");
if (!isset($_SESSION['user_info']) && count($_SESSION['user_info']) == 0)
    header('Location: login.php');
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
    <!-- morris CSS -->
    <link href="assets/plugins/morrisjs/morris.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="css/colors/blue.css" id="theme" rel="stylesheet">
    <!--This page css - Morris CSS -->



    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <!--Start of Tawk.to Script-->
   <!-- GetButton.io widget -->
<script type="text/javascript">
    (function () {
        var options = {
            whatsapp: "976893323", // WhatsApp number
            call: "976893323", // Call phone number
            call_to_action: "Envíanos un mensaje", // Call to action
            button_color: "#FF6550", // Color of button
            position: "right", // Position may be 'right' or 'left'
            order: "whatsapp,call", // Order of buttons
        };
        var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>
<!-- /GetButton.io widget -->
    <!--End of Tawk.to Script-->
</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!-- <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div> -->
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
            <?php
            $tab_requete[] = array();
            $tab_requete = getRequeteAmount();
            $tab_requete_canceled[] = array();
            $tab_requete_canceled = getRequeteCanceledAmount();
            $tab_requete_confirmed[] = array();
            $tab_requete_confirmed = getRequeteConfirmedAmount();
            $tab_requete_onride[] = array();
            $tab_requete_onride = getRequeteOnRideAmount();
            $tab_requete_completed[] = array();
            $tab_requete_completed = getRequeteCompletedAmount();
            $tab_requete_sales_today[] = array();
            $tab_requete_sales_today = getRequeteAllSaleTodayAmount();
            $tab_requete_earn_month[] = array();
            $tab_requete_earn_month = getRequeteMonthEarnAmount();
            $tab_requete_earn_today[] = array();
            $tab_requete_earn_today = getRequeteTodayEarnAmount();
            $tab_requete_earn_week[] = array();
            $tab_requete_earn_week = getRequeteWeekEarnAmount();
            $tab_requete_new[] = array();
            $tab_requete_new = getRequeteNewAmount();
            $tab_currency[] = array();
            $tab_currency = getEnabledCurrency();
            $tab_driver[] = array();
            $tab_driver = getConducteur();
            $tab_customer[] = array();
            $tab_customer = getUserApp();
            ?>
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor"><?php echo $earning ?>: <?php if ($tab_requete_completed[0]['earning'] != '') {
                                                                            echo $tab_currency[0]['symbole'] . ' ' . $tab_requete_completed[0]['earning'];
                                                                        } else {
                                                                            echo $tab_currency[0]['symbole'] . ' 0';
                                                                        }  ?></h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $home ?></a></li>
                        <li class="breadcrumb-item active"><?php echo $dashboard ?></li>
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
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-user"></i></h3>
                                </div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info"><?php echo count($tab_driver) ?></h3>
                                    <h5 class="text-muted m-b-0"><?php echo $driver ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-user"></i></h3>
                                </div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info"><?php echo count($tab_customer) ?></h3>
                                    <h5 class="text-muted m-b-0"><?php echo $customer ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3>
                                </div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info"><?php echo $tab_currency[0]['symbole'] . ' ' . $tab_requete[0]['montant'] ?></h3>
                                    <h5 class="text-muted m-b-0"><?php echo $customer ?> Todo el viaje</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3>
                                </div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info"><?php if ($tab_requete_new[0]['montant'] != '') {
                                                                    echo $tab_currency[0]['symbole'] . ' ' . $tab_requete_new[0]['montant'];
                                                                } else {
                                                                    echo $tab_currency[0]['symbole'] . ' 0';
                                                                }  ?></h3>
                                    <h5 class="text-muted m-b-0"><?php echo $new_ride ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3>
                                </div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info"><?php if ($tab_requete_confirmed[0]['montant'] != '') {
                                                                    echo $tab_currency[0]['symbole'] . ' ' . $tab_requete_confirmed[0]['montant'];
                                                                } else {
                                                                    echo $tab_currency[0]['symbole'] . ' 0';
                                                                }  ?></h3>
                                    <h5 class="text-muted m-b-0"><?php echo $confirmed_ride ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3>
                                </div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info"><?php if ($tab_requete_onride[0]['montant'] != '') {
                                                                    echo $tab_currency[0]['symbole'] . ' ' . $tab_requete_onride[0]['montant'];
                                                                } else {
                                                                    echo $tab_currency[0]['symbole'] . ' 0';
                                                                }  ?></h3>
                                    <h5 class="text-muted m-b-0"><?php echo $on_ride ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3>
                                </div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info"><?php if ($tab_requete_completed[0]['montant'] != '') {
                                                                    echo $tab_currency[0]['symbole'] . ' ' . $tab_requete_completed[0]['montant'];
                                                                } else {
                                                                    echo $tab_currency[0]['symbole'] . ' 0';
                                                                }  ?></h3>
                                    <h5 class="text-muted m-b-0"><?php echo $completed_ride ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3>
                                </div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info"><?php if ($tab_requete_canceled[0]['montant'] != '') {
                                                                    echo $tab_currency[0]['symbole'] . ' ' . $tab_requete_canceled[0]['montant'];
                                                                } else {
                                                                    echo $tab_currency[0]['symbole'] . ' 0';
                                                                }  ?></h3>
                                    <h5 class="text-muted m-b-0"><?php echo $canceled_ride ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <h4>Ganancias</h4>
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3>
                                </div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info"><?php if ($tab_requete_confirmed[0]['earning'] != '') {
                                                                    echo $tab_currency[0]['symbole'] . ' ' . $tab_requete_confirmed[0]['earning'];
                                                                } else {
                                                                    echo $tab_currency[0]['symbole'] . ' 0';
                                                                }  ?></h3>
                                    <h5 class="text-muted m-b-0"><?php echo $confirmed_ride ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3>
                                </div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info"><?php if ($tab_requete_onride[0]['earning'] != '') {
                                                                    echo $tab_currency[0]['symbole'] . ' ' . $tab_requete_onride[0]['earning'];
                                                                } else {
                                                                    echo $tab_currency[0]['symbole'] . ' 0';
                                                                }  ?></h3>
                                    <h5 class="text-muted m-b-0"><?php echo $on_ride ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3>
                                </div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info"><?php if ($tab_requete_completed[0]['earning'] != '') {
                                                                    echo $tab_currency[0]['symbole'] . ' ' . $tab_requete_completed[0]['earning'];
                                                                } else {
                                                                    echo $tab_currency[0]['symbole'] . ' 0';
                                                                }  ?></h3>
                                    <h5 class="text-muted m-b-0"><?php echo $completed_ride ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3>
                                </div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info"><?php if ($tab_requete_canceled[0]['earning'] != '') {
                                                                    echo $tab_currency[0]['symbole'] . ' ' . $tab_requete_canceled[0]['earning'];
                                                                } else {
                                                                    echo $tab_currency[0]['symbole'] . ' 0';
                                                                }  ?></h3>
                                    <h5 class="text-muted m-b-0"><?php echo $canceled_ride ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3>
                                </div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info"><?php if ($tab_requete_sales_today[0]['nb_sales'] != '') {
                                                                    echo $tab_requete_sales_today[0]['nb_sales'] . ' ventas';
                                                                } else {
                                                                    echo '0 sales';
                                                                }  ?></h3>
                                    <h5 class="text-muted m-b-0"><?php echo $driver_sale_today ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3>
                                </div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info"><?php if ($tab_requete_earn_today[0]['earning'] != '') {
                                                                    echo $tab_currency[0]['symbole'] . ' ' . $tab_requete_earn_today[0]['earning'];
                                                                } else {
                                                                    echo $tab_currency[0]['symbole'] . ' 0';
                                                                }  ?></h3>
                                    <h5 class="text-muted m-b-0"><?php echo $commission_for_the_day ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3>
                                </div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info"><?php if ($tab_requete_earn_week[0]['earning'] != '') {
                                                                    echo $tab_currency[0]['symbole'] . ' ' . $tab_requete_earn_week[0]['earning'];
                                                                } else {
                                                                    echo $tab_currency[0]['symbole'] . ' 0';
                                                                }  ?></h3>
                                    <h5 class="text-muted m-b-0"><?php echo $commission_for_the_week ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="d-flex flex-row">
                                <div class="p-10 bg-info">
                                    <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3>
                                </div>
                                <div class="align-self-center m-l-20">
                                    <h3 class="m-b-0 text-info"><?php if ($tab_requete_earn_month[0]['earning'] != '') {
                                                                    echo $tab_currency[0]['symbole'] . ' ' . $tab_requete_earn_month[0]['earning'];
                                                                } else {
                                                                    echo $tab_currency[0]['symbole'] . ' 0';
                                                                }  ?></h3>
                                    <h5 class="text-muted m-b-0"><?php echo $commission_for_the_month ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><i class="mdi mdi-account m-r-5 color-success"></i><?php echo $driver_activation_request ?></h4>
                                <div class="table-responsive m-t-10" style="height:160px;">
                                    <?php
                                    $tab_conducteur[] = array();
                                    $tab_conducteur = getConducteurDisabled();
                                    ?>
                                    <table id="example24" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%" height="100%;">
                                        <thead>
                                            <tr>
                                                <th width="5%">N°</th>
                                                <th width="10%"><?php echo $photo ?></th>
                                                <th width="20%"><?php echo $last_name ?></th>
                                                <th width="20%"><?php echo $first_name ?></th>
                                                <th width="10%"><?php echo $phone ?></th>
                                                <th width="10%"><?php echo $national_card_number ?></th>
                                                <th width="5%"><?php echo $status ?></th>
                                                <th width="5%"><?php echo $created ?></th>
                                                <th width="5%"><?php echo $modified ?></th>
                                                <th width="10%"><?php echo $actions ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            for ($i = 0; $i < count($tab_conducteur); $i++) {
                                                echo '
                                                        <tr>
                                                            <td>' . ($i + 1) . '</td>
                                                            <td>
                                                                <div class="user-profile" style="width:100%;">
                                                                    <div class="profile-img" style="width:100%;">';
                                                if ($tab_conducteur[$i]['photo_path'] == "") {
                                                    echo '<img src="on_demand_taxi_webservice/images/app_user/user_profile.jpg" alt="" width="100%" style="width:70px;height:70px;">';
                                                } else {
                                                    echo '<img src="on_demand_taxi_webservice/images/app_user/' . $tab_conducteur[$i]['photo_path'] . '" alt="" width="100%" style="width:70px;height:70px;">';
                                                }

                                                echo '</div>
                                                                </div>
                                                            </td>
                                                            <td>' . $tab_conducteur[$i]['nom'] . '</td>
                                                            <td>' . $tab_conducteur[$i]['prenom'] . '</td>
                                                            <td>' . $tab_conducteur[$i]['phone'] . '</td>
                                                            <td>' . $tab_conducteur[$i]['cnib'] . '</td>
                                                            <td><span class="';
                                                if ($tab_conducteur[$i]['statut'] == "yes") {
                                                    echo "badge badge-success";
                                                } else {
                                                    echo "badge badge-danger";
                                                }
                                                echo '">' . $tab_conducteur[$i]['statut'] . '</span></td>
                                                            <td>' . $tab_conducteur[$i]['creer'] . '</td>
                                                            <td>' . $tab_conducteur[$i]['modifier'] . '</td>
                                                            <td>
                                                                <a href="query/action.php?id_conducteur_activer=' . $tab_conducteur[$i]['id'] . '" class="btn btn-success btn-sm" data-toggle="tooltip" data-original-title="Activar"> <i class="fa fa-check"></i> </a>
                                                                <a href="conducteur-detail.php?id_conducteur=' . $tab_conducteur[$i]['id'] . '" class="btn btn-inverse btn-sm" data-toggle="tooltip" data-original-title="Ver detalles"> <i class="fa fa-ellipsis-h"></i> </a>


                                                                 <input type="hidden" value="' . $tab_conducteur[$i]['id'] . '" name="" id="id_conducteur_' . $i . '">
                                                               
                                                                
                                                                <a href="query/action.php?id_conducteur_desactiver=' . $tab_conducteur[$i]['id'] . '" class="btn btn-inverse btn-sm" data-toggle="tooltip" data-original-title="Desactivaar"> <i class="fa fa-close"></i> </a>
                                                            </td>
                                                        </tr>
                                                    ';
                                            }
                                            ?>
                                            <!-- <input type="hidden" value="'.$tab_conducteur[$i]['id'].'" name="" id="id_conducteur_'.$i.'">
                                            <button type="button" onclick="modConducteur(id_conducteur_'.$i.'.value);" class="btn btn-warning btn-sm" data-original-title="Modify" data-toggle="modal" data-target="#conducteur-mod"><i class="fa fa-pencil"></i></button>
                                            <a href="query/action.php?id_conducteur='.$tab_conducteur[$i]['id'].'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-trash"></i> </a>
                                            <a href="query/action.php?id_conducteur_desactiver='.$tab_conducteur[$i]['id'].'" class="btn btn-inverse btn-sm" data-toggle="tooltip" data-original-title="Deactivate"> <i class="fa fa-close"></i> </a> -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                $tab_currency[] = array();
                                $tab_currency = getEnabledCurrency();
                                // print_r(getEarningStatsDashboard(2020));
                                ?>
                                <h4 class="card-title"><?php echo $earning_stats ?> (<?php echo $tab_currency[0]['symbole']; ?>)</h4>
                                <div id="chart">
                                    <canvas id="chart2" height="150"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-lg-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><i class="mdi mdi-briefcase m-r-5 color-success"></i><?php echo $taxi_booking ?></h4>
                                <h6 class="card-subtitle"><?php echo $coordinate_all_actors_involved_in_the_taxi_services ?></h6>
                                <div class="button-group">
                                    <a href="requete.php" class="btn waves-effect waves-light btn-lg btn-success">Ver todo </a>
                                    <a href="requete-new.php" class="btn waves-effect waves-light btn-lg btn-success"><?php echo $new ?></a>
                                    <a href="requete-confirmed.php" class="btn waves-effect waves-light btn-lg btn-success"><?php echo $confirmed ?></a>
                                    <a href="requete-onride.php" class="btn waves-effect waves-light btn-lg btn-success"><?php echo $on_ride ?></a>
                                    <a href="requete-completed.php" class="btn waves-effect waves-light btn-lg btn-success"><?php echo $completed ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><i class="mdi mdi-settings m-r-5 color-info"></i><?php echo $admin_tools ?></h4>
                                <h6 class="card-subtitle"><?php echo $user_and_user_category_management_tool ?></h6>
                                <div class="button-group">
                                    <a href="categorie-user.php" class="btn waves-effect waves-light btn-lg btn-info"><?php echo $user_cat ?></a>
                                    <a href="user.php" class="btn waves-effect waves-light btn-lg btn-info">Usuarios admin.</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><i class="mdi mdi-account m-r-5 color-warning"></i><?php echo $user_app ?></h4>
                                <h6 class="card-subtitle"><?php echo $track_the_activities_of_users ?></h6>
                                <div class="button-group">
                                    <a href="list-user.php" class="btn waves-effect waves-light btn-lg btn-warning"><?php echo $user_list ?> </a>
                                    <a href="conducteur.php" class="btn waves-effect waves-light btn-lg btn-warning"><?php echo $driver_list ?> </a>
                                    <!-- <a href="suggestion.php" class="btn waves-effect waves-light btn-lg btn-warning">Suggestion</a>
                                    <a href="commentaire-avis.php" class="btn waves-effect waves-light btn-lg btn-warning">Commentaire & avis</a> -->
                                    <!-- <button type="button" class="btn waves-effect waves-light btn-lg btn-info">Type d'alerte</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-lg-3 col-lg-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><i class="mdi mdi-chart-areaspline m-r-5 color-primary"></i>Reporting &amp; Stats</h4>
                                <h6 class="card-subtitle">Reporting activities using reporting tools.</h6>
                                <div class="button-group">
                                    <a href="" class="btn waves-effect waves-light btn-lg btn-primary">Statistics</a>
                                </div>
                            </div>
                        </div>
                    </div> -->

                </div>
                <div class="row m-t-0">
                    <div class="col-md-12">

                        <h3><?php echo $live_tracking ?></h3>
                        <div id="map"></div>
                        <script>
                            function initMap() {
                                var uluru = {
                                    lat: -12.048450013723475,
                                    lng: -77.03997664824078
                                };
                                setTimeout(() => {
                                    var map = new google.maps.Map(document.getElementById('map'), {
                                        zoom: 14,
                                        center: uluru
                                    });
                                    var marker = new google.maps.Marker({
                                        position: uluru,
                                        map: map
                                    });
                                }, 500);
                            }
                        </script>
                        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDNTUx4Vw6kXa4kKaPyi4p-A741yKc4lbw&callback=initMap">
                        </script>

                    </div>
                </div>
                <!-- Row -->


                <!-- Row -->

                <!-- Row -->
                <!-- Row -->

                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- <div class="right-sidebar">
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
                </div> -->
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
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--sparkline JavaScript -->
    <script src="assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--morris JavaScript -->
    <script src="assets/plugins/raphael/raphael-min.js"></script>
    <script src="assets/plugins/morrisjs/morris.min.js"></script>
    <!-- Chart JS -->
    <script src="js/dashboard1.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->

    <script src="assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

    <!-- Chart JS -->
    <script src="assets/plugins/Chart.js/chartjs.init.js"></script>
    <script src="assets/plugins/Chart.js/Chart.min.js"></script>
    <!-- ============================================================== -->


    <!--Custom JavaScript -->
    <!-- <script src="js/custom.min.js"></script> -->
    <script src="assets/plugins/toast-master/js/jquery.toast.js"></script>
    <script src="js/toastr.js"></script>
    <!-- This is data table -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script>
        // $('#example24').DataTable();
    </script>

    <script>
        initMap();
        var gmarkers = [];
        var map;

        function initMap() {
            $.ajax({
                url: "query/ajax/getAllVehicle.php",
                type: "POST",
                data: {
                    "id": "ok"
                },
                success: function(data) {
                    var data_parse = JSON.parse(data);
                    if (data_parse.length != 0) {
                        for (var i = 0; i < data_parse.length; i++) {
                            var lat = data_parse[i].latitude;
                            var lng = data_parse[i].longitude;
                            var prenom = data_parse[i].prenom;
                            var phone = data_parse[i].phone;
                            var nom = data_parse[i].nom;
                            var online = data_parse[i].online;
                            var nom_prenom = prenom + " " + nom;
                            var uluru = {
                                lat: parseFloat(lat),
                                lng: parseFloat(lng)
                            };
                            if (i == 0) {
                                map = new google.maps.Map(document.getElementById('map'), {
                                    zoom: 15,
                                    center: uluru
                                });
                            }
                            if (online == "yes")
                                var image = 'https://firebasestorage.googleapis.com/v0/b/imagentaxi-e3659.appspot.com/o/marker.png?alt=media&token=ad345784-2352-4377-939c-66be0a19f8a2';
                            else
                                var image = 'https://firebasestorage.googleapis.com/v0/b/imagentaxi-e3659.appspot.com/o/marker_red.png?alt=media&token=35fb2391-2c64-431e-a5cf-2b0a16a06564';
                            var marker = new google.maps.Marker({
                                position: uluru,
                                map: map,
                                icon: image,
                                title: nom_prenom
                            });
                            showInfo(map, marker, phone);
                            // Push your newly created marker into the array:
                            gmarkers.push(marker);
                        }
                    } else {
                        var uluru = {
                            lat: parseFloat("11.111111"),
                            lng: "-1.133344"
                        };
                        map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 15,
                            center: uluru
                        });
                    }
                    addYourLocationButton(map, marker);
                }
            });
        }

        function showInfo(map, marker, phone) {
            var infoWindow = new google.maps.InfoWindow();
            google.maps.event.addListener(marker, 'click', function() {
                var markerContent = "<h4>Nombre : " + marker.getTitle() + "</h4> <h6>Telefono : " + phone + "</h6>";
                infoWindow.setContent(markerContent);
                infoWindow.open(map, this);
            });
            new google.maps.event.trigger(marker, 'click');
        }

        function addYourLocationButton(map, marker) {
            var controlDiv = document.createElement('div');

            var firstChild = document.createElement('button');
            firstChild.style.backgroundColor = '#fff';
            firstChild.style.border = 'none';
            firstChild.style.outline = 'none';
            firstChild.style.width = '40px';
            firstChild.style.height = '40px';
            firstChild.style.borderRadius = '2px';
            firstChild.style.boxShadow = '0 1px 4px rgba(0,0,0,0.3)';
            firstChild.style.cursor = 'pointer';
            firstChild.style.marginRight = '10px';
            firstChild.style.padding = '0px';
            firstChild.title = 'Your Location';
            controlDiv.appendChild(firstChild);

            var secondChild = document.createElement('div');
            secondChild.style.margin = '10px';
            secondChild.style.width = '18px';
            secondChild.style.height = '18px';
            secondChild.style.backgroundImage = 'url(https://maps.gstatic.com/tactile/mylocation/mylocation-sprite-1x.png)';
            secondChild.style.backgroundSize = '180px 18px';
            secondChild.style.backgroundPosition = '0px 0px';
            secondChild.style.backgroundRepeat = 'no-repeat';
            secondChild.id = 'you_location_img';
            firstChild.appendChild(secondChild);

            google.maps.event.addListener(map, 'dragend', function() {
                $('#you_location_img').css('background-position', '0px 0px');
            });

            firstChild.addEventListener('click', function() {
                var imgX = '0';
                var animationInterval = setInterval(function() {
                    if (imgX == '-18') imgX = '0';
                    else imgX = '-18';
                    $('#you_location_img').css('background-position', imgX + 'px 0px');
                }, 500);
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        setTimeout(() => {
                            var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                            marker.setPosition(latlng);
                            map.setCenter(latlng);
                            clearInterval(animationInterval);
                        }, 500);
                        $('#you_location_img').css('background-position', '-144px 0px');
                    });
                } else {
                    clearInterval(animationInterval);
                    $('#you_location_img').css('background-position', '0px 0px');
                }
            });

            controlDiv.index = 1;
            map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(controlDiv);
        }

        function removeMarkers() {
            for (i = 0; i < gmarkers.length; i++) {
                gmarkers[i].setMap(null);
            }
        }

        function getVehicleAll2() {
            $.ajax({
                url: "query/ajax/getAllVehicle.php",
                type: "POST",
                data: {
                    "id": "ok"
                },
                success: function(data) {
                    var data_parse = JSON.parse(data);
                    removeMarkers();
                    for (var i = 0; i < data_parse.length; i++) {
                        var lat = data_parse[i].latitude;
                        var lng = data_parse[i].longitude;
                        var prenom = data_parse[i].prenom;
                        var phone = data_parse[i].phone;
                        var nom = data_parse[i].nom;
                        var online = data_parse[i].online;
                        var nom_prenom = prenom + " " + nom;
                        var uluru = {
                            lat: parseFloat(lat),
                            lng: parseFloat(lng)
                        };
                        if (online == "yes")
                            var image = 'https://firebasestorage.googleapis.com/v0/b/imagentaxi-e3659.appspot.com/o/marker.png?alt=media&token=ad345784-2352-4377-939c-66be0a19f8a2';
                        else
                            var image = 'https://firebasestorage.googleapis.com/v0/b/imagentaxi-e3659.appspot.com/o/marker_red.png?alt=media&token=35fb2391-2c64-431e-a5cf-2b0a16a06564';
                        var marker = new google.maps.Marker({
                            position: uluru,
                            map: map,
                            icon: image,
                            title: nom_prenom
                        });
                        showInfo(map, marker, phone);
                        // Push your newly created marker into the array:
                        gmarkers.push(marker);
                    }
                }
            });
        }

        function foo() {
            var day = new Date().getDay();
            var hours = new Date().getHours();

            // alert('day: ' + day + '  Hours : ' + hours );
            getVehicleAll2();

            if (day === 0 && hours > 12 && hours < 13) {}
            // Do what you want here:
        }

        setInterval(foo, 7000);

        apply(new Date().getFullYear());

        function apply(year) {
            $("#loader").css("display", "block");
            $.ajax({
                url: "query/ajax/getEarningStatsDashboard.php",
                type: "POST",
                data: {
                    "year": year
                },
                success: function(data) {
                    $("#chart2").remove();
                    $("#chart").append('<canvas id="chart2" height="50"></canvas>');

                    var data_parse = JSON.parse(data);

                    var ctx2 = document.getElementById("chart2").getContext("2d");
                    var v01 = 0;
                    var v02 = 0;
                    var v03 = 0;
                    var v04 = 0;
                    var v05 = 0;
                    var v06 = 0;
                    var v07 = 0;
                    var v08 = 0;
                    var v09 = 0;
                    var v10 = 0;
                    var v11 = 0;
                    var v12 = 0;
                    for (let i = 0; i < data_parse.length; i++) {
                        date = data_parse[i].creer;
                        tab_tab = date.split('-');
                        var expr = tab_tab[1];
                        var nb = expr;
                        switch (nb) {
                            case '01':
                                v01 = parseInt(v01) + parseInt(data_parse[i].montant);
                                break;
                            case '02':
                                v02 = parseInt(v02) + parseInt(data_parse[i].montant);
                                break;
                            case '03':
                                v03 = parseInt(v03) + parseInt(data_parse[i].montant);
                                break;
                            case '04':
                                v04 = parseInt(v04) + parseInt(data_parse[i].montant);
                                break;
                            case '05':
                                v05 = parseInt(v05) + parseInt(data_parse[i].montant);
                                break;
                            case '06':
                                v06 = parseInt(v06) + parseInt(data_parse[i].montant);
                                break;
                            case '07':
                                v07 = parseInt(v07) + parseInt(data_parse[i].montant);
                                break;
                            case '08':
                                v08 = parseInt(v08) + parseInt(data_parse[i].montant);
                                break;
                            case '09':
                                v09 = parseInt(v09) + parseInt(data_parse[i].montant);
                                break;
                            case '10':
                                v10 = parseInt(v10) + parseInt(data_parse[i].montant);
                                break;
                            case '11':
                                v11 = parseInt(v11) + parseInt(data_parse[i].montant);
                                break;
                            default:
                                v12 = parseInt(v12) + parseInt(data_parse[i].montant);
                                break;
                        }
                    }

                    var data_tab = [];
                    for (let i = 0; i < 12; i++) {
                        switch (i) {
                            case 0:
                                data_tab[i] = v01;
                                break;
                            case 1:
                                data_tab[i] = v02;
                                break;
                            case 2:
                                data_tab[i] = v03;
                                break;
                            case 3:
                                data_tab[i] = v04;
                                break;
                            case 4:
                                data_tab[i] = v05;
                                break;
                            case 5:
                                data_tab[i] = v06;
                                break;
                            case 6:
                                data_tab[i] = v07;
                                break;
                            case 7:
                                data_tab[i] = v08;
                                break;
                            case 8:
                                data_tab[i] = v09;
                                break;
                            case 9:
                                data_tab[i] = v10;
                                break;
                            case 10:
                                data_tab[i] = v11;
                                break;
                            case 11:
                                data_tab[i] = v12;
                                break;
                            case 12:
                                data_tab[i] = v13;
                                break;
                            default:
                                data_tab[i] = '0';
                                break;
                        }
                    }
                    var data2 = {
                        labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                        datasets: [{
                            label: "Earning stats",
                            fillColor: "#f7020e",
                            strokeColor: "#f7020e",
                            highlightFill: "#f7020e",
                            highlightStroke: "#f7020e",
                            data: data_tab
                        }]
                    };

                    var chart2 = new Chart(ctx2).Bar(data2, {
                        scaleBeginAtZero: true,
                        scaleShowGridLines: true,
                        scaleGridLineColor: "rgba(0,0,0,.005)",
                        scaleGridLineWidth: 0,
                        scaleShowHorizontalLines: true,
                        scaleShowVerticalLines: true,
                        barShowStroke: true,
                        barStrokeWidth: 0,
                        tooltipCornerRadius: 2,
                        barDatasetSpacing: 3,
                        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
                        responsive: true
                    });
                }
            });
        }
    </script>
    <!-- Custom Theme JavaScript -->

    <?php if (isset($_SESSION['status']) &&  $_SESSION['status'] == 1) { ?>
        <script>
            showInfo();
        </script>
    <?php } else if (isset($_SESSION['status']) &&  $_SESSION['status'] == 2) { ?>
        <script>
            showFailed();
        </script>
    <?php } else if (isset($_SESSION['status']) &&  $_SESSION['status'] == 3) { ?>
        <script>
            showWarningIncorrect();
        </script>
    <?php }
    unset($_SESSION['status']); ?>
</body>

</html>