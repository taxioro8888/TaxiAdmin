<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
    $con->set_charset("utf8");
    
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        $prenom = $_POST['firstname'];
        $prenom = str_replace("'","\'",$prenom);
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $mdp = $_POST['password'];
        $mdp = str_replace("'","\'",$mdp);
        $login_type = $_POST['login_type'];
        $tonotify = $_POST['tonotify'];
        $account_type = $_POST['account_type'];
        $mdp = md5($mdp);
        $date_heure = date('Y-m-d H:i:s');

        if($account_type == "customer"){
            $chkemail = mysqli_query($con, "select * from tj_user_app where phone='$phone'");
            if (mysqli_num_rows($chkemail) > 0) {
                $row = $chkemail->fetch_assoc();
                
                if ($login_type != 'phone' && $row['login_type'] == $login_type) {
                    $response['msg']['etat'] = 1;
                    $response['msg']['message'] = "Inicio de sesión social";
                    unset($row['mdp']);
                    $response['user'] = $row;
                } else {
                    $response['msg']['etat'] = 2;
                    $response['msg']['message'] = "El número de teléfono ya existe ...";
                }
            } else {
                    $insertdata = mysqli_query($con, "insert into tj_user_app(prenom,phone,mdp,statut,login_type,tonotify,creer)
                    values('$prenom','$phone','$mdp','yes','$login_type','$tonotify','$date_heure')");
                    $id = mysqli_insert_id($con);
                    if ($insertdata > 0) {
                        $response['msg']['etat'] = 1;
                        
                        $get_user = mysqli_query($con, "select * from tj_user_app where id=$id");
                        $row = $get_user->fetch_assoc();
                        unset($row['mdp']);
                        $row['user_cat'] = "user_app";
    
                        $get_currency = mysqli_query($con, "select * from tj_currency where statut='yes' limit 1");
                        $row_currency = $get_currency->fetch_assoc();
                        $row['currency'] = $row_currency['symbole'];

                        $get_country = mysqli_query($con, "select * from tj_country where statut='yes' limit 1");
                        $row_country = $get_country->fetch_assoc();
                        $row['country'] = $row_country['code'];

                        // $get_commission = mysqli_query($con, "select * from tj_commission where statut='yes' limit 1");
                        // $row_commission = $get_commission->fetch_assoc();
                        // $row['commission'] = $row_commission['value'];
                        
                        $response['user'] = $row;
                    } else {
                        $response['msg']['etat'] = 3;
                    }
            }
        }else{
            $chkemail = mysqli_query($con, "select * from tj_conducteur where phone='$phone'");
            if (mysqli_num_rows($chkemail) > 0) {
                $row = $chkemail->fetch_assoc();
                
                if ($login_type != 'phone' && $row['login_type'] == $login_type) {
                    $response['msg']['etat'] = 1;
                    $response['msg']['message'] = "Social Login";
                    unset($row['mdp']);
                    $response['user'] = $row;
                } else {
                    $response['msg']['etat'] = 2;
                    $response['msg']['message'] = "El número de teléfono ya existe ...";
                }
            } else {
                    $insertdata = mysqli_query($con, "insert into tj_conducteur(online,prenom,phone,mdp,statut,login_type,tonotify,creer,statut_licence,statut_nic,statut_vehicule,email)
                    values('yes','$prenom','$phone','$mdp','no','$login_type','$tonotify','$date_heure','no','no','no','$email')");
                    $id = mysqli_insert_id($con);
                    if ($insertdata > 0) {
                        $response['msg']['etat'] = 1;
                        
                        $get_user = mysqli_query($con, "select * from tj_conducteur where id=$id");
                        $row = $get_user->fetch_assoc();
                        unset($row['mdp']);
                        $row['user_cat'] = "conducteur";
    
                        $get_currency = mysqli_query($con, "select * from tj_currency where statut='yes' limit 1");
                        $row_currency = $get_currency->fetch_assoc();
                        $row['currency'] = $row_currency['symbole'];

                        $get_country = mysqli_query($con, "select * from tj_country where statut='yes' limit 1");
                        $row_country = $get_country->fetch_assoc();
                        $row['country'] = $row_country['code'];

                        // $get_commission = mysqli_query($con, "select * from tj_commission where statut='yes' limit 1");
                        // $row_commission = $get_commission->fetch_assoc();
                        // $row['commission'] = $row_commission['value'];
                        
                        $response['user'] = $row;
                    } else {
                        $response['msg']['etat'] = 3;
                    }

                    $sql = "SELECT * FROM tj_settings LIMIT 1";
                    $result = mysqli_query($con,$sql);
                    $email_admin = '';
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                        $email_admin = $row['email'];
                    }

                    // if($email != ""){
                        $to = $email_admin;
                        $subject = "Nuevo suscriptor || taxi Uber";
                        $message = '
                            <body style="margin:100px; background: #ffc600; ">
                                <div width="100%" style="background: #ffc600; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
                                    <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px; background: #fff;">
                                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">
                                            <tbody>
                                                <tr>
                                                    <td style="vertical-align: top; padding-bottom:30px;" align="center">
                                                        <img src="http://projets.hevenbf.com/on_demand_taxi/on_demand_taxi_webservice/images/logo_taxijaune.jpg" alt="logo Taxi Jaune" style="border:none" width="15%">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div style="padding: 40px; background: #fff;">
                                            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                                <tbody>
                                                    <tr>
                                                        <h3>Nuevo Supcriptor </h3>
                                                        <p>Un nuevo conductor ha enviado sus datos revise por favor.</p>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </body>
                        ';
                        // Always set content-type when sending HTML email
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\b";
                        $headers .= 'From: Taxi Jaune' . "\r\n";
                        mail($to,$subject,$message,$headers);
                    // }
            }
        }

        echo json_encode($response);
        mysqli_close($con);
    }
?>