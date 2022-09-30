<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
    $con->set_charset("utf8");
    include_once 'GCM.php';
    
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        $id_requete = $_POST['id_ride'];
        $id_user = $_POST['id_user'];
        $creer = $_POST['current_date'];

        $sql = "SELECT * FROM tj_requete_book WHERE id=$id_requete";
        $result = mysqli_query($con,$sql);
        $id_user_app = "";
        $depart_name = "";
        $destination_name = "";
        $latitude_depart = "";
        $longitude_depart = "";
        $latitude_arrivee = "";
        $longitude_arrivee = "";
        $distance = "";
        $duree = "";
        $montant = "";
        $trajet = "";
        $statut = "";
        $statut_paiement = "";
        $id_conducteur = "";
        // $creer = "";
        $modifier = "";
        $date_book = "";
        $nb_day = "";
        $heure_depart = "";
        $cu = "";
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $id_user_app = $row['id_user_app'];
            $depart_name = $row['depart_name'];
            $destination_name = $row['destination_name'];
            $latitude_depart = $row['latitude_depart'];
            $longitude_depart = $row['longitude_depart'];
            $latitude_arrivee = $row['latitude_arrivee'];
            $longitude_arrivee = $row['longitude_arrivee'];
            $distance = $row['distance'];
            $duree = $row['duree'];
            $montant = $row['montant'];
            $trajet = $row['trajet'];
            $statut = $row['statut'];
            $statut_paiement = $row['statut_paiement'];
            $id_conducteur = $row['id_conducteur'];
            $id_payment_method = $row['id_payment_method'];
            // $creer = $row['creer'];
            $modifier = $row['modifier'];
            $date_book = $row['date_book'];
            $nb_day = $row['nb_day'];
            $heure_depart = $row['heure_depart'];
            $cu = $row['cu'];
        }
        
        $reqchkonride = "SELECT id FROM tj_requete 
        WHERE trajet='$trajet' AND depart_name='$depart_name' AND destination_name='$destination_name' AND
         id_conducteur=$id_conducteur AND id_user_app=$id_user_app AND latitude_depart='$latitude_depart' AND longitude_depart='$longitude_depart' 
         AND latitude_arrivee='$latitude_arrivee' AND longitude_arrivee='$longitude_arrivee' AND 
         creer='$creer',distance=$distance,montant=$cu,duree='$duree',id_payment_method=$id_payment_method";
        $chkonride = mysqli_query($con, $reqchkonride);
        if (mysqli_num_rows($chkonride) > 0) {
            $response['msg']['etat'] = 1;
                
            $tmsg='';
            $terrormsg='';
            
            $title=str_replace("'","\'","Comienzo de su viaje");
            $msg=str_replace("'","\'","Tu viaje comenzó, no olvides ponerte el cinturón de seguridad.");
            
            $tab[] = array();
            $tab = explode("\\",$msg);
            $msg_ = "";
            for($i=0; $i<count($tab); $i++){
                $msg_ = $msg_."".$tab[$i];
            }

            $gcm = new GCM();

            $message=array("body"=>$msg_,"title"=>$title,"sound"=>"mySound","tag"=>"rideonride");

            $query = "select fcm_id from tj_user_app where fcm_id<>'' and id=$id_user";
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
        }else{
        
            $query = "INSERT INTO tj_requete(id_payment_method,trajet,depart_name,destination_name,id_conducteur,id_user_app,latitude_depart,longitude_depart,latitude_arrivee,longitude_arrivee,statut,creer,distance,montant,duree)
            VALUES($id_payment_method,'$trajet','$depart_name','$destination_name',$id_conducteur,$id_user_app,'$latitude_depart','$longitude_depart','$latitude_arrivee','$longitude_arrivee','on ride','$creer',$distance,$cu,'$duree')";
            $insertdata = mysqli_query($con, $query);
    
            // $updatedata = mysqli_query($con, "update tj_requete set statut='on ride' where id=$id_requete");
    
            if ($insertdata > 0) {
                $response['msg']['etat'] = 1;
                
                $tmsg='';
                $terrormsg='';
                
                $title=str_replace("'","\'","Comienzo de su viaje");
                $msg=str_replace("'","\'","Tu viaje comenzó, no olvides ponerte el cinturón de seguridad.");
                
                $tab[] = array();
                $tab = explode("\\",$msg);
                $msg_ = "";
                for($i=0; $i<count($tab); $i++){
                    $msg_ = $msg_."".$tab[$i];
                }
    
                $gcm = new GCM();
    
                $message=array("body"=>$msg_,"title"=>$title,"sound"=>"mySound","tag"=>"rideonride");
    
                $query = "select fcm_id from tj_user_app where fcm_id<>'' and id=$id_user";
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
            } else {
                $response['msg']['etat'] = 2;
            }
        }

        echo json_encode($response);
        mysqli_close($con);
    }
?>