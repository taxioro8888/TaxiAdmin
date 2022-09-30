<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
    $con->set_charset("utf8");
    include_once 'GCM.php';
    
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        $id_requete = $_POST['id_ride'];
        $id_user = $_POST['id_user'];
        $driver_name = $_POST['driver_name'];

        $updatedata = mysqli_query($con, "update tj_requete_book set statut='confirmed' where id=$id_requete AND statut='new'");

        if ($updatedata > 0) {
            $response['msg']['etat'] = 1;
            
            $tmsg='';
            $terrormsg='';
            
            $title=str_replace("'","\'","Confirmación de su viaje");
            $msg=str_replace("'","\'",$driver_name." confirmó su reserva de viaje");
            
            $tab[] = array();
            $tab = explode("\\",$msg);
            $msg_ = "";
            for($i=0; $i<count($tab); $i++){
                $msg_ = $msg_."".$tab[$i];
            }

            $gcm = new GCM();

            $message=array("body"=>$msg_,"title"=>$title,"sound"=>"mySound","tag"=>"rideconfirmed_book");

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

        echo json_encode($response);
        mysqli_close($con);
    }
?>