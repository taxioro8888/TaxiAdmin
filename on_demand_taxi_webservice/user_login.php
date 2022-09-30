<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
	$con->set_charset("utf8");
    $response = array();

    if($_SERVER['REQUEST_METHOD'] =='POST'){
        $date_heure = date('Y-m-d H:i:s');
        $id_user = "";
        $mdp = md5($_POST['mdp']);
        $telephone = $_POST['phone'];
        $mdp = str_replace("'","\'",$mdp);
        $telephone = str_replace("'","\'",$telephone);
        $checkuser = mysqli_query($con, "select * from tj_user_app where phone='$telephone'");
        if (mysqli_num_rows($checkuser)) {
            $checkaccount = mysqli_query($con, "select * from tj_user_app where phone='$telephone' and statut='yes'");
            if (mysqli_num_rows($checkaccount)) {
                $checkpwd = mysqli_query($con, "select * from tj_user_app where phone='$telephone' and mdp='$mdp'");
                if (mysqli_num_rows($checkpwd)) {
                    $response['msg']['etat'] = 1;
                    $response['msg']['message'] = "Success";
                    $row = $checkuser->fetch_assoc();
                    unset($row['mdp']);
                    $row['user_cat'] = "user_app";
                    $row['online'] = "";
                    $id_user = $row['id'];

                    $get_currency = mysqli_query($con, "select * from tj_currency where statut='yes' limit 1");
                    $row_currency = $get_currency->fetch_assoc();
                    $row['currency'] = $row_currency['symbole'];

                    $get_country = mysqli_query($con, "select * from tj_country where statut='yes' limit 1");
                    $row_country = $get_country->fetch_assoc();
                    $row['country'] = $row_country['code'];

                    // $get_commission = mysqli_query($con, "select * from tj_commission where statut='yes' limit 1");
                    // $row_commission = $get_commission->fetch_assoc();
                    // $row['commission'] = $row_commission['value'];

                    /** A décommenter pour le déploiement **/
                    /*$ip = $_SERVER['REMOTE_ADDR']; 
                    $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
                    if($query && $query['status'] == 'success') {
                        $pays = $query['country'];
                        $ville = $query['city'];
                        $region = $query['regionName'];
                        $ip_adress = $query['query'];
                    } else {
                        $pays = "";
                        $ville = "";
                        $region = "";
                    }
                    
                    $sql = "INSERT INTO pha_connexion(pays,ville,region,ip_adress,id_user,date_connexion)
                    VALUE('$pays', '$ville', '$region', '$ip_adress', $id_user, '$date_heure')";
                    mysqli_query($con,$sql);*/

                    $response['user'] = $row;
                } else {
                    $response['msg']['etat'] = 2;
                }
            } else {
                $response['msg']['etat'] = 3;
            }
        } else {
            $checkuser = mysqli_query($con, "select * from tj_conducteur where phone='$telephone'");
            if (mysqli_num_rows($checkuser)) {
                $checkaccount = mysqli_query($con, "select * from tj_conducteur where phone='$telephone' and statut='yes'");
                if (mysqli_num_rows($checkaccount)) {
                    $checkpwd = mysqli_query($con, "select * from tj_conducteur where phone='$telephone' and mdp='$mdp'");
                    if (mysqli_num_rows($checkpwd)) {
                        $response['msg']['etat'] = 1;
                        $response['msg']['message'] = "Success";
                        $row = $checkuser->fetch_assoc();
                        unset($row['mdp']);
                        $row['user_cat'] = "conducteur";
                        $id_user = $row['id'];

                        $get_currency = mysqli_query($con, "select * from tj_currency where statut='yes' limit 1");
                        $row_currency = $get_currency->fetch_assoc();
                        $row['currency'] = $row_currency['symbole'];

                        $get_country = mysqli_query($con, "select * from tj_country where statut='yes' limit 1");
                        $row_country = $get_country->fetch_assoc();
                        $row['country'] = $row_country['code'];

                        $get_vehicle = mysqli_query($con, "select * from tj_vehicule where statut='yes' AND id_conducteur=$id_user");
                        $row_vehicle = $get_vehicle->fetch_assoc();
                        $row['brand'] = $row_vehicle['brand'];
                        $row['model'] = $row_vehicle['model'];
                        $row['color'] = $row_vehicle['color'];
                        $row['numberplate'] = $row_vehicle['numberplate'];

                        // $checkdrivertaxi = mysqli_query($con, "select t.brand,t.color,t.type,t.licence,t.insurance,t.immatriculation,tt.libelle,tt.image
                        //  from tj_taxi t, tj_taxi_type tt where t.id_taxi_type=tt.id and t.statut='yes' and t.id_conducteur=$id_user limit 1");
                        // if (mysqli_num_rows($checkdrivertaxi)) {
                        //     $row['checkdrivertaxi'] = "yes";
                        //     $row_driver_taxi = $checkdrivertaxi->fetch_assoc();
                        //     $row['brand'] = $row_driver_taxi['brand'];
                        //     $row['color'] = $row_driver_taxi['color'];
                        //     $row['type'] = $row_driver_taxi['type'];
                        //     $row['licence'] = $row_driver_taxi['licence'];
                        //     $row['insurance'] = $row_driver_taxi['insurance'];
                        //     $row['immatriculation'] = $row_driver_taxi['immatriculation'];
                        //     $row['libelle'] = $row_driver_taxi['libelle'];
                        //     $row['image'] = $row_driver_taxi['image'];
                        // }else{
                        //     $row['checkdrivertaxi'] = "no";
                        // }

                        /** A décommenter pour le déploiement **/
                        /*$ip = $_SERVER['REMOTE_ADDR']; 
                        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
                        if($query && $query['status'] == 'success') {
                            $pays = $query['country'];
                            $ville = $query['city'];
                            $region = $query['regionName'];
                            $ip_adress = $query['query'];
                        } else {
                            $pays = "";
                            $ville = "";
                            $region = "";
                        }
                        
                        $sql = "INSERT INTO pha_connexion(pays,ville,region,ip_adress,id_user,date_connexion)
                        VALUE('$pays', '$ville', '$region', '$ip_adress', $id_user, '$date_heure')";
                        mysqli_query($con,$sql);*/

                        $response['user'] = $row;
                    } else {
                        $response['msg']['etat'] = 2;
                    }
                } else {
                    $response['msg']['etat'] = 3;
                }
            }else{
                $response['msg']['etat'] = 0;
            }
        }

        echo json_encode($response);
        mysqli_close($con);
    }
?>