<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
    $con->set_charset("utf8");
    
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        // $lat1 = 11.0112;
        // $lng1 = -1.3565565;
        // $id_cat_taxi = 8;
        $lat1 = $_POST['lat1'];
        $lng1 = $_POST['lng1'];
        $id_cat_taxi = $_POST['type_vehicle'];
        // $lat1 = "1.11545";
        // $lng1 = "-11.455656";

        $sql = "SELECT c.id,c.nom,c.prenom,c.phone,c.email,c.online,c.photo_path as photo,c.latitude,c.longitude,v.id as idVehicule,v.brand,v.model,v.color,v.numberplate,v.passenger,tv.libelle as typeVehicule
        FROM tj_type_vehicule tv, tj_vehicule v, tj_conducteur c
        WHERE v.id_type_vehicule=tv.id AND v.id_conducteur=c.id AND v.statut='yes' AND c.statut='yes' AND c.online!='no' AND tv.id=$id_cat_taxi";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
          $id_conducteur = $row['id'];

          /*if($row['latitude'] != '' && $row['latitude'] != '')
              $row['distance'] = distance($row['latitude'],$row['longitude'],$lat1,$lng1,'K');*/

          // Nb avis conducteur
          $sql_nb_avis = "SELECT count(id) as nb_avis, sum(niveau) as somme FROM tj_note WHERE id_conducteur=$id_conducteur";
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

          $row['moyenne'] = $moyenne;
          $output[] = $row;
        }

        /*function cmp($a,$b){
            return strcmp($a["distance"], $b["distance"]);
        }
        
        if(mysqli_num_rows($result) > 0)
          usort($output, "cmp");*/
        
        function distance($lat1, $lon1, $lat2, $lon2, $unit) {
          if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
          }
          else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);
        
            if ($unit == "K") {
              return ($miles * 1.609344);
            } else if ($unit == "N") {
              return ($miles * 0.8684);
            } else {
              return $miles;
            }
          }
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