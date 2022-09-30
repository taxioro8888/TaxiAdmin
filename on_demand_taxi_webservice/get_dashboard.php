<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
    $con->set_charset("utf8");
    
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        // $id_diver = 60;
        $id_diver = $_POST['id_diver'];
        // $today = $_POST['today'];
        $date_start = date('Y-m-d 00:00:00');
        $date_end = date('Y-m-d 23:59:59');

        $sql = "SELECT count(id) as nb_new FROM tj_requete WHERE statut='new' AND id_conducteur=$id_diver";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {

            // Nb confirmed
            $sql_nb_confirmed = "SELECT count(id) as nb_confirmed FROM tj_requete WHERE statut='confirmed' AND id_conducteur=$id_diver";
            $result_nb_confirmed = mysqli_query($con,$sql_nb_confirmed);
            if(mysqli_num_rows($result_nb_confirmed) > 0){
                $row_nb_confirmed = mysqli_fetch_assoc($result_nb_confirmed);
                $nb_confirmed = $row_nb_confirmed['nb_confirmed'];
            }else{
                $nb_confirmed = "0";
            }
            $row['nb_confirmed'] = $nb_confirmed;

            // Nb confirmed
            $sql_nb_onride = "SELECT count(id) as nb_onride FROM tj_requete WHERE statut='on ride' AND id_conducteur=$id_diver";
            $result_nb_onride = mysqli_query($con,$sql_nb_onride);
            if(mysqli_num_rows($result_nb_onride) > 0){
                $row_nb_onride = mysqli_fetch_assoc($result_nb_onride);
                $nb_onride = $row_nb_onride['nb_onride'];
            }else{
                $nb_onride = "0";
            }
            $row['nb_onride'] = $nb_onride;

            // Nb confirmed
            $sql_nb_completed = "SELECT count(id) as nb_completed FROM tj_requete WHERE statut='completed' AND id_conducteur=$id_diver";
            $result_nb_completed = mysqli_query($con,$sql_nb_completed);
            if(mysqli_num_rows($result_nb_completed) > 0){
                $row_nb_completed = mysqli_fetch_assoc($result_nb_completed);
                $nb_completed = $row_nb_completed['nb_completed'];
            }else{
                $nb_completed = "0";
            }

            $row['nb_completed'] = $nb_completed;

            // Nb sales
            $sql_nb_sales = "SELECT count(id) as nb_sales FROM tj_requete WHERE statut='completed' AND id_conducteur=$id_diver AND creer >= '$date_start' AND creer <= '$date_end'";
            $result_nb_sales = mysqli_query($con,$sql_nb_sales);
            if(mysqli_num_rows($result_nb_sales) > 0){
                $row_nb_sales = mysqli_fetch_assoc($result_nb_sales);
                $nb_sales = $row_nb_sales['nb_sales'];
            }else{
                $nb_sales = "0";
            }

            $row['nb_sales'] = $nb_sales;

            $sql_cu = "SELECT montant as cu
            FROM tj_requete r, tj_user_app u, tj_conducteur c WHERE r.statut='completed' AND r.id_user_app=u.id AND r.id_conducteur=c.id AND r.id_conducteur=$id_diver
            ORDER BY r.id DESC";
            $result_cu = mysqli_query($con,$sql_cu);
            $earning = 0;

            $sql_com = "SELECT value FROM tj_commission WHERE type='Percentage' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com = mysqli_query($con,$sql_com);
            if(mysqli_num_rows($result_com) > 0){
                $row_com = mysqli_fetch_assoc($result_com);
                $value = $row_com['value'];
                $value = 1-(float)($value);

                // output data of each row
                $value_fixed = 0;
                $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
                $result_com_fixed = mysqli_query($con,$sql_com_fixed);
                if(mysqli_num_rows($result_com_fixed) > 0){
                    $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                    $value_fixed = $row_com_fixed['value'];
                }

                while($row_cu = mysqli_fetch_assoc($result_cu)) {
                    $cu = $row_cu['cu'];
                    $cu = $cu * $value;
                    $earning = (Float)$earning + ((Float)$cu - (Float)$value_fixed);
                }
            }else{
                $sql_com = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
                $result_com = mysqli_query($con,$sql_com);
                if(mysqli_num_rows($result_com) > 0){
                    $row_com = mysqli_fetch_assoc($result_com);

                    // output data of each row
                    $value_fixed = 0;
                    $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
                    $result_com_fixed = mysqli_query($con,$sql_com_fixed);
                    $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                    if(mysqli_num_rows($result_com_fixed) > 0){
                        $value_fixed = $row_com_fixed['value'];
                    }

                    while($row_cu = mysqli_fetch_assoc($result_cu)) {
                        $cu = $row_cu['cu'];
                        $earning = (Float)$earning + ((Float)$cu - (Float)$value_fixed);
                    }
                }else{

                }
            }

            if($earning < 0)
                $row['today_earning'] = "0";
            else
                $row['today_earning'] = $earning;

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
    }
?>