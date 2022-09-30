<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
    $con->set_charset("utf8");
    include_once 'GCM.php';
    
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        $id_requete = $_POST['id_ride'];
        $id_user = $_POST['id_driver'];
        $id_user_app = $_POST['id_user_app'];
        $amount_new = $_POST['amount'];

        $sql = "SELECT amount FROM tj_user_app WHERE id=$id_user_app";
        $result = mysqli_query($con,$sql);

        $amount = "0";
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $amount = $row['amount'];
            $amount = $amount-$amount_new;
            if($amount < 0){
                $amount = 0;
            }
            $sql = "UPDATE tj_user_app SET amount=$amount WHERE id=$id_user_app";
            mysqli_query($con,$sql);
        }

        $updatedata = mysqli_query($con, "update tj_requete set statut_paiement='yes' where id=$id_requete");

        if ($updatedata > 0) {
            $response['msg']['etat'] = 1;
            $response['msg']['amount'] = $amount;
            
            $tmsg='';
            $terrormsg='';
            
            $title=str_replace("'","\'","Pago de la carrera");
            $msg=str_replace("'","\'","Su cliente acaba de pagar su viaje.");
            
            $tab[] = array();
            $tab = explode("\\",$msg);
            $msg_ = "";
            for($i=0; $i<count($tab); $i++){
                $msg_ = $msg_."".$tab[$i];
            }

            $gcm = new GCM();

            $message=array("body"=>$msg_,"title"=>$title,"sound"=>"mySound","tag"=>"ridecompleted");

            $query = "select fcm_id from tj_conducteur where fcm_id<>'' and id=$id_user";
            $result = mysqli_query($con, $query);

            $tokens = array();
            if (mysqli_num_rows($result) > 0) {
                while ($user = $result->fetch_assoc()) {
                    if (!empty($user['fcm_id'])) {
                        $tokens[] = $user['fcm_id'];
                    }
                }
            }
            $temp = array();
            if (count($tokens) > 0) {
                $gcm->send_notification($tokens, $message, $temp);
            }

            
            // Get user info
            $query = "select u.fcm_id,u.id,u.nom,u.prenom,u.email from tj_requete r, tj_user_app u where r.id_user_app=u.id and r.id=$id_requete";
            $result = mysqli_query($con, $query);

            // Get Ride Info
            $query_ride = "select distance,duree,montant,creer,trajet from tj_requete where id=$id_requete";
            $result_ride = mysqli_query($con, $query_ride);
            $ride = $result_ride->fetch_assoc();
            $distance = $ride['distance'];
            $duree = $ride['duree'];
            $cout = $ride['montant'];
            $date_heure = $ride['creer'];
            $img_name = $ride['trajet'];

            $tokens = array();
            $nom = "";
            $prenom = "";
            $email = "";
            if (mysqli_num_rows($result) > 0) {
                while ($user = $result->fetch_assoc()) {
                    if (!empty($user['fcm_id'])) {
                        $tokens[] = $user['fcm_id'];
                        $nom = $user['nom'];
                        $prenom = $user['prenom'];
                        $email = $user['email'];
                    }
                }
            }

            if($email != ""){
                $to = $email;
                $subject = "Recibo de pago - guerrerosystem";
                $message = '
                    <body style="margin:100px; background: #ffc600; ">
                        <div width="100%" style="background: #ffc600; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
                            <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px; background: #fff;">
                                <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">
                                    <tbody>
                                        <tr>
                                            <td style="vertical-align: top; padding-bottom:30px;" align="center">
                                                <img src="http://projets.hevenbf.com/on_demand_taxi/on_demand_taxi_webservice/images/logo_taxijaune.jpg" alt="logo Taxi Cab - On Demand Taxi" style="border:none" width="15%">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div style="padding: 40px; background: #fff;">
                                    <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                        <tbody>
                                            <tr>
                                                <img src="http://projets.hevenbf.com/on_demand_taxi/on_demand_taxi_webservice/images/recu_trajet_course/'.$img_name.'" alt="logo Taxi Cab - On Demand Taxi" style="border:none" width="100%">
                                                <h3>Recibo de pago </h3>
                                                <p>Hola '.$prenom.' '.$nom.'</p>
                                                <b><u>Detalles de su recibo de pago:</u></b><br>
                                                <p><b>Distancia:</b> '.$distance.' M</p>
                                                <p><b>Duración:</b> '.$duree.'</p>
                                                <p><b>costo:</b> '.$cout.' $</p>
                                                <p><b>Fecha:</b> '.$date_heure.'</p>
                                                <br/>
                                                <p>Buena continuacion y hasta pronto!</p>
                                                <p>Saludos Taxi guerrerosystem</p>
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
                $headers .= ' de taxi-guerrerosystem' . "\r\n";
                mail($to,$subject,$message,$headers);
            }
        } else {
            $response['msg']['etat'] = 2;
        }

        echo json_encode($response);
        mysqli_close($con);
    }
?>