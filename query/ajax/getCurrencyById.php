<?php 
	include('../fonction.php');
    function getCurrencyById1($id_currency){
        $output[] = array();
        $output = getCurrencyById($id_currency);
        echo json_encode($output);
    }
    if(isset($_POST['id_currency'])){
        getCurrencyById1($_POST['id_currency']);
    }else{
		header('Location: 404erreur.php'); 
    }
?>