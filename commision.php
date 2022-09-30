
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
    include("dico.php");
    $tab_infos_user[] = array();
    $id_user = "";
    if(!isset($_SESSION['user_info']) && count($_SESSION['user_info']) == 0)
        header('Location: login.php');
    else{
        $tab_infos_user = $_SESSION['user_info'];
        $id_user = $tab_infos_user['id'];
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
                    <h3 class="text-themecolor"><?php echo $commission; ?></h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="homex.php"><?php echo $home; ?></a></li>
                        <li class="breadcrumb-item"><?php echo $codification; ?></li>
                        <li class="breadcrumb-item active"><?php echo $commission; ?></li>
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
                    <div class="col-md-12">
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                            <h3 class="text-info"><i class="fa fa-exclamation-circle"></i> <?php echo $information; ?></h3> 
                            <?php echo $info_msg; ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $percentage_commission; ?></h4>
                                <!-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6> -->
                                <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#add-commission-perc"><i class="fa fa-plus m-r-10"></i>Agregar</button> 
                                <div id="add-commission-perc" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content bg-gris">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel"><?php echo $add_a_commission; ?></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <form class="form-horizontal " action="query/action.php" method="post">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-4 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation"><?php echo $title; ?></label>
                                                                    <input type="text" class="form-control " placeholder="" name="libelle_commission_perc" id="libelle_commission_perc" required> 
                                                                    <div class="invalid-feedback">
                                                                        Désolé, entrez l'intitulé de la catégorie de devis
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation"><?php echo $value; ?></label>
                                                                    <input type="number" step="0.01" value="0.01" min="0.01" max="0.99" class="form-control " placeholder="" name="value_commission_perc" id="value_commission_perc" required> 
                                                                    <div class="invalid-feedback">
                                                                        Désolé, entrez l'intitulé de la catégorie de devis
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation"><?php echo $type; ?></label>
                                                                    <select name="type_commission_perc" id="type_commission_perc"class="form-control" required>
                                                                        <option value="Percentage" selected>Percentage</option>
                                                                        <!-- <option value="Fixed">Fixed</option> -->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-dark waves-effect"><?php echo $save; ?></button>
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?php echo $cancel; ?></button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div id="commission-mod-perc" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content bg-gris">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel"><?php echo $modify_a_commision; ?></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <form class="form-horizontal " action="query/action.php" method="post">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <input type="hidden" name="id_commission_mod_perc" id="id_commission_mod_perc" value="<?php echo $id_user; ?>">
                                                            <div class="col-md-4 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation"><?php echo $title; ?></label>
                                                                    <input type="text" class="form-control " placeholder="" name="libelle_commission_mod_perc" id="libelle_commission_mod_perc" required> 
                                                                    <div class="invalid-feedback">
                                                                        Désolé, entrez l'intitulé de la catégorie de devis
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation"><?php echo $value; ?>Value</label>
                                                                    <input type="number" class="form-control" step="0.01" value="0.01" min="0.01" max="0.99" placeholder="" name="value_commission_mod_perc" id="value_commission_mod_perc" required> 
                                                                    <div class="invalid-feedback">
                                                                        Désolé, entrez l'intitulé de la catégorie de devis
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation"><?php echo $type; ?></label>
                                                                    <select name="type_commission_mod_perc" id="type_commission_mod_perc"class="form-control" required>
                                                                        <option value="Percentage" selected>Percentage</option>
                                                                        <!-- <option value="Fixed">Fixed</option> -->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-dark waves-effect"><?php echo $save; ?></button>
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?php echo $cancel; ?></button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div class="table-responsive m-t-10">
                                    <?php
                                        $tab_commission[] = array(); 
                                        $tab_commission = getCommissionPerc();
                                    ?>
                                    <table id="example24" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th><?php echo $name; ?></th>
                                                <th><?php echo $value; ?></th>
                                                <th><?php echo $type; ?></th>
                                                <th><?php echo $status; ?></th>
                                                <th><?php echo $created; ?></th>
                                                <th><?php echo $modified; ?></th>
                                                <th><?php echo $actions; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                for($i=0; $i<count($tab_commission); $i++){
                                                    echo'
                                                        <tr>
                                                            <td>'.($i+1).'</td>
                                                            <td>'.$tab_commission[$i]['libelle'].'</td>
                                                            <td>'.$tab_commission[$i]['value'].'</td>
                                                            <td>'.$tab_commission[$i]['type'].'</td>
                                                            <td><span class="'; if($tab_commission[$i]['statut'] == "yes"){echo "badge badge-success";}else{echo "badge badge-danger";} echo '">'.$tab_commission[$i]['statut'].'</span></td>
                                                            <td>'.$tab_commission[$i]['creer'].'</td>
                                                            <td>'.$tab_commission[$i]['modifier'].'</td>
                                                            <td>
                                                                <input type="hidden" value="'.$tab_commission[$i]['id'].'" name="" id="id_commission_perc_'.$i.'">
                                                                <button type="button" onclick="modCommissionPerc(id_commission_perc_'.$i.'.value);" class="btn btn-warning btn-sm" data-original-title="Modificar" data-toggle="modal" data-target="#commission-mod-perc"><i class="fa fa-pencil"></i></button>
                                                                <a href="query/action.php?id_commission_activer='.$tab_commission[$i]['id'].'" class="btn btn-success btn-sm" data-toggle="tooltip" data-original-title="Activar"> <i class="fa fa-check"></i> </a>

                                                                <a href="query/action.php?id_commission_desactiver='.$tab_commission[$i]['id'].'" class="btn btn-inverse btn-sm" data-toggle="tooltip" data-original-title="Desactivar"> <i class="fa fa-close"></i> </a>
                                                                 <a href="query/action.php?id_commission='.$tab_commission[$i]['id'].'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-original-title="Eliminar"> <i class="fa fa-trash"></i> </a> 
                                                            </td>
                                                        </tr>
                                                    ';
                                                }
                                            ?>
                                            <!-- <a href="query/action.php?id_commission_desactiver='.$tab_commission[$i]['id'].'" class="btn btn-inverse btn-sm" data-toggle="tooltip" data-original-title="Deactivate"> <i class="fa fa-close"></i> </a> -->
                                            <!-- <a href="query/action.php?id_commission='.$tab_commission[$i]['id'].'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-trash"></i> </a> -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $fixed_commission; ?></h4>
                                <!-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6> -->
                                <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#add-commission"><i class="fa fa-plus m-r-10"></i>Agregar</button> 
                                <div id="add-commission" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content bg-gris">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel"><?php echo $add_a_commission; ?></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <form class="form-horizontal " action="query/action.php" method="post">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-4 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation"><?php echo $title; ?></label>
                                                                    <input type="text" class="form-control " placeholder="" name="libelle_commission" id="libelle_commission" required> 
                                                                    <div class="invalid-feedback">
                                                                        Désolé, entrez l'intitulé de la catégorie de devis
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation"><?php echo $value; ?></label>
                                                                    <input type="number" class="form-control " placeholder="" min="1" name="value_commission" id="value_commission" required> 
                                                                    <div class="invalid-feedback">
                                                                        Désolé, entrez l'intitulé de la catégorie de devis
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation"><?php echo $type; ?></label>
                                                                    <select name="type_commission" id="type_commission"class="form-control" required>
                                                                        <!-- <option value="Percentage" selected>Percentage</option> -->
                                                                        <option value="Fixed">Fixed</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-dark waves-effect"><?php echo $save; ?></button>
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?php echo $cancel; ?></button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div id="commission-mod" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content bg-gris">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel"><?php echo $modify_a_commision; ?></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <form class="form-horizontal " action="query/action.php" method="post">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <input type="hidden" name="id_commission_mod" id="id_commission_mod" value="<?php echo $id_user; ?>">
                                                            <div class="col-md-4 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation"><?php echo $title; ?></label>
                                                                    <input type="text" class="form-control " placeholder="" name="libelle_commission_mod" id="libelle_commission_mod" required> 
                                                                    <div class="invalid-feedback">
                                                                        Désolé, entrez l'intitulé de la catégorie de devis
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation"><?php echo $value; ?></label>
                                                                    <input type="number" class="form-control" placeholder="" min="1" name="value_commission_mod" id="value_commission_mod" required> 
                                                                    <div class="invalid-feedback">
                                                                        Désolé, entrez l'intitulé de la catégorie de devis
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 m-b-0">
                                                                <div class="form-group mb-3">
                                                                    <label class="mr-sm-2" for="designation"><?php echo $type; ?></label>
                                                                    <select name="type_commission_mod" id="type_commission_mod"class="form-control" required>
                                                                        <!-- <option value="Percentage" selected>Percentage</option> -->
                                                                        <option value="Fixed">Precio fijo</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-dark waves-effect"><?php echo $save; ?></button>
                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal"><?php echo $cancel; ?></button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <div class="table-responsive m-t-10">
                                    <?php
                                        $tab_commission[] = array(); 
                                        $tab_commission = getCommissionFixed();
                                    ?>
                                    <table id="example24" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>N°</th>
                                                <th><?php echo $name; ?></th>
                                                <th><?php echo $value; ?></th>
                                                <th><?php echo $type; ?></th>
                                                <th><?php echo $status; ?></th>
                                                <th><?php echo $created; ?></th>
                                                <th><?php echo $modified; ?></th>
                                                <th><?php echo $actions; ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                for($i=0; $i<count($tab_commission); $i++){
                                                    echo'
                                                        <tr>
                                                            <td>'.($i+1).'</td>
                                                            <td>'.$tab_commission[$i]['libelle'].'</td>
                                                            <td>'.$tab_commission[$i]['value'].'</td>
                                                            <td>'.$tab_commission[$i]['type'].'</td>
                                                            <td><span class="'; if($tab_commission[$i]['statut'] == "yes"){echo "badge badge-success";}else{echo "badge badge-danger";} echo '">'.$tab_commission[$i]['statut'].'</span></td>
                                                            <td>'.$tab_commission[$i]['creer'].'</td>
                                                            <td>'.$tab_commission[$i]['modifier'].'</td>
                                                            <td>
                                                                <input type="hidden" value="'.$tab_commission[$i]['id'].'" name="" id="id_commission_'.$i.'">
                                                                <button type="button" onclick="modCommission(id_commission_'.$i.'.value);" class="btn btn-warning btn-sm" data-original-title="Editar" data-toggle="modal" data-target="#commission-mod"><i class="fa fa-pencil"></i></button>
                                                                <a href="query/action.php?id_commission_activer='.$tab_commission[$i]['id'].'" class="btn btn-success btn-sm" data-toggle="tooltip" data-original-title="Activar"> <i class="fa fa-check"></i> </a>
                                                                <a href="query/action.php?id_commission_desactiver='.$tab_commission[$i]['id'].'" class="btn btn-inverse btn-sm" data-toggle="tooltip" data-original-title="DesActivar"> <i class="fa fa-close"></i> </a>

                                                                 <a href="query/action.php?id_commission='.$tab_commission[$i]['id'].'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-original-title="Eliminar"> <i class="fa fa-trash"></i> </a> 
                                                            </td>
                                                        </tr>
                                                    ';
                                                }
                                            ?>
                                            <!-- <a href="query/action.php?id_commission='.$tab_commission[$i]['id'].'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-trash"></i> </a> -->
                                        </tbody>
                                    </table>
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
    $('#example24').DataTable();
    </script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    <script>
        function modCommission(id_commission){
            $.ajax({
                url: "query/ajax/getCommissionById.php",
                type: "POST",
                data: {"id_commission":id_commission},
                success: function (data) {
                    $("#id_commission_mod").empty();
                    $("#libelle_commission_mod").empty();
                    $("#value_commission_mod").empty();

                    var data_parse = JSON.parse(data);

                    $("#id_commission_mod").val(data_parse[0].id);
                    $("#libelle_commission_mod").val(data_parse[0].libelle);
                    $("#value_commission_mod").val(data_parse[0].value);
                    $("#type_commission_mod").val(data_parse[0].type).selected;
                }
            });
        }
        function modCommissionPerc(id_commission){
            $.ajax({
                url: "query/ajax/getCommissionById.php",
                type: "POST",
                data: {"id_commission":id_commission},
                success: function (data) {
                    $("#id_commission_mod_perc").empty();
                    $("#libelle_commission_mod_perc").empty();
                    $("#value_commission_mod_perc").empty();

                    var data_parse = JSON.parse(data);

                    $("#id_commission_mod_perc").val(data_parse[0].id);
                    $("#libelle_commission_mod_perc").val(data_parse[0].libelle);
                    $("#value_commission_mod_perc").val(data_parse[0].value);
                    $("#type_commission_mod_perc").val(data_parse[0].type).selected;
                }
            });
        }
    </script>

    
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
