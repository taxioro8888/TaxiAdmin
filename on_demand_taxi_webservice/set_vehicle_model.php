<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
    $con->set_charset("utf8");
    
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        $id_user = $_POST['id_user'];
        $model = $_POST['model'];
        $model = str_replace("'","\'",$model);
        $user_cat = $_POST['user_cat'];
        $date_heure = date('Y-m-d H:i:s');

        // if($user_cat == 'user_app')
        //     $updatedata = mysqli_query($con, "update tj_user_app set model='$model', modifier='$date_heure' where id=$id_user");
        // else
            $updatedata = mysqli_query($con, "update tj_vehicule set model='$model', modifier='$date_heure' where id_conducteur=$id_user");

        if ($updatedata > 0) {
            $response['msg']['etat'] = 1;
            $response['msg']['model'] = $model;
        } else {
            $response['msg']['etat'] = 2;
        }

        echo json_encode($response);
        mysqli_close($con);
    }
?>