<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
	$con->set_charset("utf8");
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id_user = $_POST['id_user'];
        $cat_user = $_POST['cat_user'];

        if($cat_user == "user_app"){
            $sql = "SELECT amount FROM tj_user_app WHERE id=$id_user";
        }else{
            $sql = "SELECT amount FROM tj_conducteur WHERE id=$id_user";
        }
        $result = mysqli_query($con,$sql);

        $amount = "0";
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $amount = $row['amount'];
        }
        
        if(mysqli_num_rows($result) > 0){
            $response['msg']['amount'] = $amount;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }

        echo json_encode($response);
        mysqli_close($con);
    }
?>