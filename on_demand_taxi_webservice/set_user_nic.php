<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
    $con->set_charset("utf8");
    
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        $id_user = $_POST['id_driver'];
        $image = $_POST['image'];
        $image_name = $_POST['image_name'];
        $user_cat = $_POST['user_cat'];
        $date_heure = date('Y-m-d H:i:s');

        if(!empty($image)){
            $temp = explode(".", $image_name);
            $newfile = $image_name.'_'.$id_user.'_'.microtime(true).'_'.rand(0,round(microtime(true)));
            $extension = '.'.end($temp);
            $img_name = $newfile.''.$extension;

            $ImagePath = "images/app_user/$img_name";
        }else{
            $img_name = "";
        }
        $updatedata = mysqli_query($con, "update tj_conducteur set photo_nic='$image', photo_nic_path='$img_name', modifier='$date_heure' where id=$id_user");

        if ($updatedata > 0) {
            if(!empty($image))
                file_put_contents($ImagePath,base64_decode($image));

            $updatedata = mysqli_query($con, "update tj_conducteur set statut_nic='yes' where id=$id_user");
            
            $response['msg']['etat'] = 1;
            $response['msg']['image'] = $image;
        } else {
            $response['msg']['etat'] = 2;
        }

        echo json_encode($response);
        mysqli_close($con);
    }
?>