<?php 
	include('../fonction.php');
    function getTypeTaxiById1($id_taxi_type){
        $output[] = array();
        $output = getTypeTaxiById($id_taxi_type);
        echo json_encode($output);
    }
    if(isset($_POST['id_taxi_type'])){
        getTypeTaxiById1($_POST['id_taxi_type']);
    }else{
		header('Location: 404erreur.php'); 
    }
?>