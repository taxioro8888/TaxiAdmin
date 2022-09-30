<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
    $con->set_charset("utf8");

        $sql = "SELECT * FROM tj_type_vehicule";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {

            $get_commission = mysqli_query($con, "select * from tj_commission where type='fixed' limit 1");
            $row_commission = $get_commission->fetch_assoc();
            $row['statut_commission'] = $row_commission['statut'];
            $row['commission'] = $row_commission['value'];
            $row['type'] = $row_commission['type'];

            $get_commission_perc = mysqli_query($con, "select * from tj_commission where type='percentage' limit 1");
            $row_commission_perc = $get_commission_perc->fetch_assoc();
            $row['statut_commission_perc'] = $row_commission_perc['statut'];
            $row['commission_perc'] = $row_commission_perc['value'];
            $row['type_perc'] = $row_commission_perc['type'];

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