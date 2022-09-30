<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
    $con->set_charset("utf8");
    include_once 'GCM.php';
    
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        $id_requete = $_POST['id_ride'];
        $id_user = $_POST['id_user'];

        $updatedata = mysqli_query($con, "update tj_requete set statut='completed' where id=$id_requete");

        if ($updatedata > 0) {
            $response['msg']['etat'] = 1;
            
            $tmsg='';
            $terrormsg='';
            
            $title=str_replace("'","\'","Fin de tu viaje");
            $msg=str_replace("'","\'","Ha llegado a su destino. Adiós y nos vemos pronto");
            
            $tab[] = array();
            $tab = explode("\\",$msg);
            $msg_ = "";
            for($i=0; $i<count($tab); $i++){
                $msg_ = $msg_."".$tab[$i];
            }

            $gcm = new GCM();

            $message=array("body"=>$msg_,"title"=>$title,"sound"=>"mySound","tag"=>"ridecompleted");

            // Get user info
            $query = "select fcm_id,nom,prenom,email from tj_user_app where fcm_id<>'' and id=$id_user";
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