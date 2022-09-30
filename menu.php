<!-- Nom &amp; Prénom: WOUMTANA P. Youssouf
            Téléphone: +226 63 86 22 46 / 73 35 41 41
                Email: issoufwoumtana@gmail.com -->
<?php
    // include("lang/en.php");
    // include("query/fonction.php");
    if(!isset($_SESSION['user_info']) && count($_SESSION['user_info']) == 0)
        header('Location: login.php');
?>
<!-- User profile -->
<div class="user-profile">
    <!-- User profile image -->
    <div class="profile-img"> 
        <img src="assets/images/users/taxi.png" alt="user" />
        <!-- this is blinking heartbit-->
        <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div>
    </div>
    <?php
        $tab_user_info[] = array();
        $tab_user_info = $_SESSION['user_info'];
    ?>
    <!-- User profile text-->
    <div class="profile-text">
        <h5><?php echo $tab_user_info['nom_prenom']; ?></h5>
        <a href="query/action.php?logout=yes" class="" data-toggle="tooltip" title="Log out"><i class="mdi mdi-power"></i></a>
        <div class="dropdown-menu animated flipInY">
            <!-- text-->
            <a href="#" class="dropdown-item"><i class="ti-user"></i> <?php echo $my_profile ?></a>
            <!-- text-->
            <a href="#" class="dropdown-item"><i class="ti-wallet"></i> <?php echo $password ?></a>
            <div class="dropdown-divider"></div>
            <!-- text-->
            <a href="query/action.php?logout=yes" class="dropdown-item"><i class="fa fa-power-off"></i> <?php echo $log_out ?></a>
            <!-- text-->
        </div>
    </div>
</div>
<!-- End User profile text-->
<!-- Sidebar navigation-->
<nav class="sidebar-nav">
    <ul id="sidebarnav">
        <li class="nav-devider"></li>
        <li class="nav-small-cap"><?php echo $MONITORING_THE_MOBILE ?></li>
        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-home"></i>
                <span class="hide-menu"><?php echo $home ?></span>
            </a>
            <ul aria-expanded="false" class="collapse">
                <li><a href="homex.php"><?php echo $dashboard ?></a></li>
            </ul>
        </li>
        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-account-multiple"></i>
                <span class="hide-menu"><?php echo $user_app ?></span>
            </a>
            <ul aria-expanded="false" class="collapse">
                <li><a href="list-user.php"><?php echo $customer ?></a></li>
                <li><a href="conducteur.php"><?php echo $driver ?></a></li>
                <li><a href="notification.php"><?php echo $notification ?></a></li>
                <!-- <li><a href="commentaire-avis.php">Commentaire & Avis</a></li> -->
            </ul>
        </li>
        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-chart-bar"></i>
                <span class="hide-menu"><?php echo $statistics ?></span>
            </a>
            <ul aria-expanded="false" class="collapse">
                <li><a href="statistics-customer.php"><?php echo $customer ?></a></li>
                <li><a href="statistics-driver.php"><?php echo $driver ?></a></li>
                <li><a href="statistics-earning.php"><?php echo $earning ?></a></li>
                <!-- <li><a href="commentaire-avis.php">Commentaire & Avis</a></li> -->
            </ul>
        </li>
        <li class="nav-small-cap"><?php echo $PARAMETER_OF_MOBILE ?></li>
        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-settings-box"></i><span class="hide-menu"><?php echo $codification ?></span></a>
            <ul aria-expanded="false" class="collapse">
                <li><a href="type-vehicule.php"><?php echo $vehicle_type ?></a></li>
                <li><a href="categorie-user.php"><?php echo $user_cat ?></a></li>
            </ul>
        </li>
        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-pen"></i><span class="hide-menu"><?php echo $taxi_booking ?></span></a>
            <ul aria-expanded="false" class="collapse">
                <li><a href="requete.php"><?php echo $all ?></a></li>
                <li><a href="requete-new.php"><?php echo $new ?></a></li>
                <li><a href="requete-confirmed.php"><?php echo $confirmed ?></a></li>
                <li><a href="requete-onride.php"><?php echo $on_ride ?></a></li>
                <li><a href="requete-completed.php"><?php echo $completed ?></a></li>
                <li><a href="requete-canceled.php"><?php echo $canceled_reject ?></a></li>
            </ul>
        </li>
        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-pen"></i><span class="hide-menu"><?php echo $vehicle_rental ?></span></a>
            <ul aria-expanded="false" class="collapse">
                <li><a href="type-vehicule-rental.php"><?php echo $vehicle_type ?></a></li>
                <li><a href="vehicule.php"><?php echo $vehicle ?></a></li>
                <li><a href="location-vehicule.php"><?php echo $vehicle_rent ?></a></li>
            </ul>
        </li>
        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                <i class="mdi mdi-settings"></i>
                <span class="hide-menu"><?php echo $admin_tools ?></span>
            </a>
            <ul aria-expanded="false" class="collapse">
                <li><a href="country.php"><?php echo $country ?></a></li>
                <li><a href="currency.php"><?php echo $currency ?></a></li>
                <li><a href="commision.php"><?php echo $commission ?></a></li>
                <li><a href="payment-method.php"><?php echo $payment_method ?></a></li>
                <li><a href="settings.php"><?php echo $settings ?></a></li>
            </ul>
        </li>
        <!-- <li class="nav-small-cap">SUIVI DU MOBILE</li> -->
    </ul>
</nav>
<!-- End Sidebar navigation -->