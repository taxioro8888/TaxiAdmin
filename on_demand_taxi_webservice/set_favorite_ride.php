<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
    $con->set_charset("utf8");
    include_once 'GCM.php';
    
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        $user_id = $_POST['id_user_app'];
        $lat1 = $_POST['lat1'];
        $lng1 = $_POST['lng1'];
        $lat2 = $_POST['lat2'];
        $lng2 = $_POST['lng2'];
        $distance = $_POST['distance'];
        $depart_name = $_POST['depart_name'];
        $destination_name = $_POST['destination_name'];
        $fav_name = $_POST['fav_name'];
        $date_heure = date('Y-m-d H:i:s');
        
        $reqchkonride = "SELECT id FROM tj_favorite_ride 
        WHERE id_user_app=$user_id AND latitude_depart='$lat1' AND longitude_depart='$lng1' AND
        latitude_arrivee='$lat2' AND longitude_arrivee='$lng2' AND libelle='$fav_name'";
        $chkonride = mysqli_query($con, $reqchkonride);
        if (mysqli_num_rows($chkonride) > 0) {
            $response['msg']['etat'] = 3;
        }else{
            $query = "INSERT INTO tj_favorite_ride(libelle,depart_name,destination_name,id_user_app,latitude_depart,longitude_depart,latitude_arrivee,longitude_arrivee,statut,creer,distance)
            VALUES('$fav_name','$depart_name','$destination_name',$user_id,'$lat1','$lng1','$lat2','$lng2','yes','$date_heure',$distance)";
            $insertdata = mysqli_query($con, $query);
    
            if($insertdata > 0){
                $response['msg']['etat'] = 1;
            }else{
                $response['msg']['etat'] = 2;
            }
        }

        echo json_encode($response);
        mysqli_close($con);
    }
?>