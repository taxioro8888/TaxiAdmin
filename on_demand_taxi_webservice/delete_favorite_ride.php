<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
    $con->set_charset("utf8");
    include_once 'GCM.php';
    
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        $id_requete_fav = $_POST['id_ride_fav'];

        $updatedata = mysqli_query($con, "update tj_favorite_ride set statut='no' where id=$id_requete_fav");

        if ($updatedata > 0) {
            $response['msg']['etat'] = 1;
        } else {
            $response['msg']['etat'] = 2;
        }

        echo json_encode($response);
        mysqli_close($con);
    }
?>