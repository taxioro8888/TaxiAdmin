<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
    $con->set_charset("utf8");

    $sql = "SELECT * FROM tj_payment_method WHERE statut='yes'";
    $result = mysqli_query($con,$sql);
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $output[] = $row;
    }

    if(mysqli_num_rows($result) > 0){
        $response['msg'] = $output;
        $response['msg']['etat'] = 1;
    }else{
        $response['msg']['etat'] = 0;
    }
    echo json_encode($response);
    mysqli_close($con);
?>