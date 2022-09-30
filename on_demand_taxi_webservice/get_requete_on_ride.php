<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
    $con->set_charset("utf8");
    
    $months = array ("January"=>'Jan',"February"=>'Fev',"March"=>'Mar',"April"=>'Avr',"May"=>'Mai',"June"=>'Jun',"July"=>'Jul',"August"=>'Aou',"September"=>'Sep',"October"=>'Oct',"November"=>'Nov',"December"=>'Dec');
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // $id_user_app = 10;
        $id_driver = $_POST['id_driver'];

        $sql = "SELECT r.id,r.id_user_app,r.depart_name,r.destination_name,r.latitude_depart,r.longitude_depart,r.latitude_arrivee,r.longitude_arrivee,
        c.photo_path,r.date_retour,r.heure_retour,r.statut_round,r.number_poeple,r.place,r.statut,r.id_conducteur,r.creer,r.trajet,u.nom,u.prenom,r.distance,u.phone,c.nom as nomConducteur,c.prenom as prenomConducteur,c.phone as driverPhone,
        r.montant,r.duree,r.statut_paiement,m.libelle as payment,m.image as payment_image
        FROM tj_requete r, tj_user_app u, tj_conducteur c, tj_payment_method m
        WHERE r.id_user_app=u.id AND r.id_payment_method=m.id AND r.id_conducteur=$id_driver AND r.statut='on ride' AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $id_user_app = $row['id_user_app'];
            if($id_user_app != 0){
                // Conducteur
                $sql_cond = "SELECT nom as nomConducteur,prenom as prenomConducteur FROM tj_conducteur WHERE id=$id_driver";
                $result_cond = mysqli_query($con,$sql_cond);
                $row_cond = mysqli_fetch_assoc($result_cond);

                // Nb avis conducteur
                $sql_nb_avis = "SELECT count(id) as nb_avis, sum(niveau) as somme FROM tj_note WHERE id_conducteur=$id_driver";
                $result_nb_avis = mysqli_query($con,$sql_nb_avis);
                if(mysqli_num_rows($result_nb_avis) > 0){
                    $row_nb_avis = mysqli_fetch_assoc($result_nb_avis);
                    $somme = $row_nb_avis['somme'];
                    $nb_avis = $row_nb_avis['nb_avis'];
                    if($nb_avis != "0")
                        $moyenne = $somme/$nb_avis;
                    else
                        $moyenne = "0";
                }else{
                    $somme = "0";
                    $nb_avis = "0";
                    $moyenne = "0";
                }

                // Note conducteur
                $sql_note = "SELECT niveau,comment FROM tj_note WHERE id_user_app=$id_user_app AND id_conducteur=$id_driver";
                $result_note = mysqli_query($con,$sql_note);
                $row_note = mysqli_fetch_assoc($result_note);
                
                $sql_phone = "SELECT phone FROM tj_conducteur WHERE id=$id_driver";
                $result_phone = mysqli_query($con,$sql_phone);
                // output data of each row
                while($row_phone = mysqli_fetch_assoc($result_phone)) {
                    $row['driver_phone'] = $row_phone['phone'];
                }

                $row['nomConducteur'] = $row_cond['nomConducteur'];
                $row['prenomConducteur'] = $row_cond['prenomConducteur'];
                $row['nb_avis'] = $row_nb_avis['nb_avis'];
                if(mysqli_num_rows($result_note) > 0){
                    $row['niveau'] = $row_note['niveau'];
                    $row['comment'] = $row_note['comment'];
                }else{
                    $row['niveau'] = "";
                    $row['comment'] = "";
                }
                $row['moyenne'] = $moyenne;
            }else{
                $row['nomConducteur'] = "";
                $row['prenomConducteur'] = "";
                $row['nb_avis'] = "";
                $row['niveau'] = "";
                $row['moyenne'] = "";
                $row['driver_phone'] = "";
            }
            
            $row['creer'] = date("d", strtotime($row['creer']))." ".$months[date("F", strtotime($row['creer']))].". ".date("Y", strtotime($row['creer']));
            $row['date_retour'] = date("d", strtotime($row['date_retour']))." ".$months[date("F", strtotime($row['date_retour']))].". ".date("Y", strtotime($row['date_retour']));
            
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