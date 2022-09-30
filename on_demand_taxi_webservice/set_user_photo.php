<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
    $con->set_charset("utf8");
    
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        $image = $_POST['image'];
        $image_name = $_POST['image_name'];
        $user_cat = $_POST['user_cat'];
        $date_heure = date('Y-m-d H:i:s');

        if($user_cat == "user_app"){
            $id_user = $_POST['id_user'];
            if(!empty($image)){
                $temp = explode(".", $image_name);
                $newfile = $image_name.'_'.$id_user.'_'.microtime(true).'_'.rand(0,round(microtime(true)));
                $extension = '.'.end($temp);
                $img_name = $newfile.''.$extension;
    
                $ImagePath = "images/app_user/$img_name";
            }else{
                $img_name = "";
            }
            $updatedata = mysqli_query($con, "update tj_user_app set photo='$image', photo_path='$img_name', modifier='$date_heure' where id=$id_user");
    
            if ($updatedata > 0) {
                if(!empty($image))
                    file_put_contents($ImagePath,base64_decode($image)) or print_r(error_get_last());
                
                $response['msg']['etat'] = 1;
                $response['msg']['image'] = $image;
            } else {
                $response['msg']['etat'] = 2;
            }
        }else{
            $id_user = $_POST['id_driver'];
            if(!empty($image)){
                $temp = explode(".", $image_name);
                $newfile = $image_name.'_'.$id_user.'_'.microtime(true).'_'.rand(0,round(microtime(true)));
                $extension = '.'.end($temp);
                $img_name = $newfile.''.$extension;
    
                $ImagePath = "images/app_user/$img_name";
            }else{
                $img_name = "";
            }
            $updatedata = mysqli_query($con, "update tj_conducteur set photo='$image', photo_path='$img_name', modifier='$date_heure' where id=$id_user");
    
            if ($updatedata > 0) {
                if(!empty($image))
                    file_put_contents($ImagePath,base64_decode($image)) or print_r(error_get_last());
                
                $response['msg']['etat'] = 1;
                $response['msg']['image'] = $image;
            } else {
                $response['msg']['etat'] = 2;
            }
        }

        echo json_encode($response);
        mysqli_close($con);
    }
?>