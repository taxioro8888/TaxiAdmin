<?php
	date_default_timezone_set ('Africa/Ouagadougou');
	include("query/connexion.php");
    $con->set_charset("utf8");
    
    if($_SERVER['REQUEST_METHOD'] =='POST'){
        $brand = $_POST['brand'];
        $brand = str_replace("'","\'",$brand);
        $model = $_POST['model'];
        $color = $_POST['color'];
        $numberplate = $_POST['numberplate'];
        $passenger = $_POST['passenger'];
        $id_driver = $_POST['id_driver'];
        $id_categorie_vehicle = $_POST['id_categorie_vehicle'];
        $date_heure = date('Y-m-d H:i:s');

        $chkvehicle = mysqli_query($con, "select id from tj_vehicule where id_conducteur=$id_driver");
        if (mysqli_num_rows($chkvehicle) > 0) {
            $row = $chkvehicle->fetch_assoc();
            $id_vehicule = $row['id'];
            $updatedata = mysqli_query($con, "update tj_vehicule set brand='$brand',model='$model',color='$color',numberplate='$numberplate',modifier='$date_heure',id_type_vehicule=$id_categorie_vehicle where id=$id_vehicule");
            
            if ($updatedata > 0) {
                $response['msg']['etat'] = 1;
                
                $get_vehicule = mysqli_query($con, "select * from tj_vehicule where id=$id_vehicule");
                $row = $get_vehicule->fetch_assoc();
                
                $response['vehicle'] = $row;
            } else {
                $response['msg']['etat'] = 3;
            }
        } else {
            $insertdata = mysqli_query($con, "insert into tj_vehicule(passenger,brand,model,color,numberplate,id_conducteur,statut,creer,id_type_vehicule)
            values($passenger,'$brand','$model','$color','$numberplate',$id_driver,'yes','$date_heure',$id_categorie_vehicle)");
            $id = mysqli_insert_id($con);
            if ($insertdata > 0) {
                $response['msg']['etat'] = 1;
                
                $get_vehicule = mysqli_query($con, "select * from tj_vehicule where id=$id");
                $row = $get_vehicule->fetch_assoc();
                
                $response['vehicle'] = $row;
            } else {
                $response['msg']['etat'] = 3;
            }
            $updatedata = mysqli_query($con, "update tj_conducteur set statut_vehicule='yes' where id=$id_driver");
        }

        echo json_encode($response);
        mysqli_close($con);
    }
?>