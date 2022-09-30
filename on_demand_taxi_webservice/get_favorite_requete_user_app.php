<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
    $con->set_charset("utf8");
    
    $months = array ("January"=>'Jan',"February"=>'Fev',"March"=>'Mar',"April"=>'Avr',"May"=>'Mai',"June"=>'Jun',"July"=>'Jul',"August"=>'Aou',"September"=>'Sep',"October"=>'Oct',"November"=>'Nov',"December"=>'Déc');
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id_user_app = $_POST['id_user_app'];

        $sql = "SELECT * FROM tj_favorite_ride WHERE id_user_app=$id_user_app AND statut='yes' ORDER BY id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            
            $row['creer'] = date("d", strtotime($row['creer']))." ".$months[date("F", strtotime($row['creer']))].". ".date("Y", strtotime($row['creer']));

            $output[] = $row;
        }
        
        if(mysqli_num_rows($result) > 0){
            $response['msg'] = $output;
            $response['msg']['etat'] = 1;
        }else{
            $response['msg']['etat'] = 2;
        }

        echo json_encode($response);
        mysqli_close($con);
    }
?>