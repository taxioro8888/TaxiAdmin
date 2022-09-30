<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
	// include("query/fonction.php");
    $con->set_charset("utf8");
    include_once 'GCM.php';
    
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        $user_id = $_POST['user_id'];
        $lat1 = $_POST['lat1'];
        $lng1 = $_POST['lng1'];
        $lat2 = $_POST['lat2'];
        $lng2 = $_POST['lng2'];
        $cout = $_POST['cout'];
        $duree = $_POST['duree'];
        $distance = $_POST['distance'];
        $id_conducteur = $_POST['id_conducteur'];
        $id_payment = $_POST['id_payment'];
        $depart_name = $_POST['depart_name'];
        $destination_name = $_POST['destination_name'];
        $image = $_POST['image'];
        $image_name = $_POST['image_name'];
        $nb_day = $_POST['nb_day'];
        $heure_depart = $_POST['heure_depart'];
        $date_book = $_POST['date_book'];
        $cu = $_POST['price'];
        $place = $_POST['place'];
        $place = str_replace("'","\'",$place);
        $number_poeple = $_POST['number_poeple'];
        $number_poeple = str_replace("'","\'",$number_poeple);
        $statut_round = $_POST['statut_round'];
        $heure_retour = $_POST['heure_retour'];
        $date_heure = date('Y-m-d H:i:s');

        // $date_book = "";
        // for($i=0; $i<$nb_day; $i++){
        //     if($i==0){
        //         $date_book = $_POST['date_ride_'+$i];
        //     }else{
        //         $date_book = $date_book.','.$_POST['date_ride_'+$i];
        //     }
        // }

        if(!empty($image)){
            $img_name = $image_name;
            $ImagePath = "images/recu_trajet_course/$img_name";
        }else{
            $img_name = "";
        }
        $image_name = str_replace("'","\'",$image_name);

        $tmsg='';
        $terrormsg='';
        
        $title=str_replace("'","\'","Nuevo paseo");
        $msg=str_replace("'","\'","Acaba de recibir una solicitud de reserva de un cliente");
        
        $tab[] = array();
        $tab = explode("\\",$msg);
        $msg_ = "";
        for($i=0; $i<count($tab); $i++){
            $msg_ = $msg_."".$tab[$i];
        }

        $gcm = new GCM();

        $message=array("body"=>$msg_,"title"=>$title,"sound"=>"mySound","tag"=>"ridenewrider");

        $query = "select fcm_id from tj_conducteur where fcm_id<>'' and id=$id_conducteur";
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

        $date_heure = date('Y-m-d H:i:s');
        $query = "INSERT INTO tj_requete_book(statut_round,heure_retour,number_poeple,place,id_payment_method,cu,trajet,depart_name,destination_name,id_conducteur,id_user_app,latitude_depart,longitude_depart,latitude_arrivee,longitude_arrivee,statut,creer,distance,montant,duree,date_book,nb_day,heure_depart)
        VALUES('$statut_round','$heure_retour',$number_poeple,'$place',$id_payment,$cu,'$image_name','$depart_name','$destination_name',$id_conducteur,$user_id,'$lat1','$lng1','$lat2','$lng2','new','$date_heure',$distance,$cout,'$duree','$date_book',$nb_day,'$heure_depart')";
        $insertdata = mysqli_query($con, $query);

        if($insertdata > 0){
            if(!empty($image))
            file_put_contents($ImagePath,base64_decode($image));
        }

        $response['msg']['etat'] = 1;
        echo json_encode($response);
        mysqli_close($con);
    }
?>