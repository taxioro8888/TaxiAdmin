<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
	$con->set_charset("utf8");
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id_user = $_POST['id_user'];
        $cat_user = $_POST['cat_user'];
        $amount_init = $_POST['amount'];
        $date_heure = date('Y-m-d H:i:s');

        if($cat_user == "user_app"){
            $sql = "SELECT amount FROM tj_user_app WHERE id=$id_user";
        }else{
            $sql = "SELECT amount FROM tj_conducteur WHERE id=$id_user";
        }
        $result = mysqli_query($con,$sql);

        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $amount_ = $row['amount'];
            $amount = $amount_+$amount_init;
            if($cat_user == "user_app"){
                $sql = "UPDATE tj_user_app SET amount=$amount WHERE id=$id_user";
                mysqli_query($con,$sql);

                $query = "INSERT INTO tj_transaction(amount, id_user_app, creer)
                VALUES($amount_init,$id_user,'$date_heure')";
                $insertdata = mysqli_query($con, $query);
            }else{
                $sql = "UPDATE tj_conducteur SET amount=$amount WHERE id=$id_user";
            }
        }
        
        $response['msg']['etat'] = 1;
        $response['msg']['amount'] = $amount;

        echo json_encode($response);
        mysqli_close($con);
    }
?>