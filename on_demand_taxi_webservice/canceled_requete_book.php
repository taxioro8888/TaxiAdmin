<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
    $con->set_charset("utf8");
    include_once 'GCM.php';
    
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        $id_requete = $_POST['id_ride'];
        $id_driver = $_POST['id_driver'];
        $user_name = $_POST['user_name'];

        $updatedata = mysqli_query($con, "update tj_requete_book set statut='canceled' where id=$id_requete");

        if ($updatedata > 0) {
            $response['msg']['etat'] = 1;
            
            $tmsg='';
            $terrormsg='';
            
            $title=str_replace("'","\'","Cancelación de un viaje");
            $msg=str_replace("'","\'",$user_name." canceló su viaje");
            
            $tab[] = array();
            $tab = explode("\\",$msg);
            $msg_ = "";
            for($i=0; $i<count($tab); $i++){
                $msg_ = $msg_."".$tab[$i];
            }

            $gcm = new GCM();

            $message=array("body"=>$msg_,"title"=>$title,"sound"=>"mySound","tag"=>"ridecanceledrider");

            $query = "select fcm_id from tj_conducteur where fcm_id<>'' and id=$id_driver";
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