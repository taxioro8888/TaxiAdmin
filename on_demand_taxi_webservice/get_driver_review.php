<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
    $con->set_charset("utf8");
    
    $months = array ("January"=>'Jan',"February"=>'Fev',"March"=>'Mar',"April"=>'Avr',"May"=>'Mai',"June"=>'Jun',"July"=>'Jul',"August"=>'Aou',"September"=>'Sep',"October"=>'Oct',"November"=>'Nov',"December"=>'Dec');
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // $driver_id = 60;
        $driver_id = $_POST['driver_id'];

        $sql = "SELECT u.id as idUserApp,n.id as idNote,c.id as idConducteur,u.nom,u.prenom,u.photo_path,n.creer,n.modifier
        FROM tj_conducteur c, tj_note n, tj_user_app u
        WHERE n.id_conducteur=c.id AND n.id_user_app=u.id AND n.id_conducteur=$driver_id
        ORDER BY n.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $id_driver = $row['idConducteur'];
            $id_user_app = $row['idUserApp'];

            // Note conducteur
            $sql_note = "SELECT niveau,comment FROM tj_note WHERE id_user_app=$id_user_app AND id_conducteur=$id_driver";
            $result_note = mysqli_query($con,$sql_note);
            $row_note = mysqli_fetch_assoc($result_note);

            if(mysqli_num_rows($result_note) > 0){
                $row['niveau'] = $row_note['niveau'];
                $row['comment'] = $row_note['comment'];
            }else{
                $row['niveau'] = "";
                $row['comment'] = "";
            }
            
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