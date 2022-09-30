<?php 
	include('../fonction.php');
    function getCountryById1($id_country){
        $output[] = array();
        $output = getCountryById($id_country);
        echo json_encode($output);
    }
    if(isset($_POST['id_country'])){
        getCountryById1($_POST['id_country']);
    }else{
		header('Location: 404erreur.php'); 
    }
?>