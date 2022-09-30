<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
	$con->set_charset("utf8");
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id_user_app = $_POST['id_user_app'];
        // $id_user_app = 17;

        $sql = "SELECT v.id,v.brand,v.model,v.color,v.numberplate,v.statut,c.latitude,c.longitude,v.creer,v.modifier,c.id as idConducteur,c.nom,c.prenom
        FROM tj_vehicule v, tj_conducteur c
        WHERE v.id_conducteur=c.id AND v.statut='yes' AND c.online='yes'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $id_driver = $row['idConducteur'];

            $sql_new = "SELECT statut FROM tj_requete WHERE id_conducteur=$id_driver AND id_user_app=$id_user_app ORDER BY id DESC LIMIT 1";
            $result_new = mysqli_query($con,$sql_new);
            if(mysqli_num_rows($result_new) > 0){
                $row_new = mysqli_fetch_assoc($result_new);
                if($row_new['statut'] == 'new')
                    $row['statut_driver'] = 'new';
                else if($row_new['statut'] == 'confirmed')
                    $row['statut_driver'] = 'confirmed';
                else
                    $row['statut_driver'] = 'none';
            }else{
                $row['statut_driver'] = 'none';
            }

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