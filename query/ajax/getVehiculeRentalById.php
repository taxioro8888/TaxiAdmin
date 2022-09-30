<?php 
	include('../fonction.php');
    function getVehiculeRentalById1($id_vehicule){
        $output[] = array();
        $output = getVehiculeRentalById($id_vehicule);
        echo json_encode($output);
    }
    if(isset($_POST['id_vehicule'])){
        getVehiculeRentalById1($_POST['id_vehicule']);
    }else{
		header('Location: 404erreur.php'); 
    }
?>