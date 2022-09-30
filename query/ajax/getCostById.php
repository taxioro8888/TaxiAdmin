<?php 
	include('../fonction.php');
    function getCostById1($id_cost){
        $output[] = array();
        $output = getCostById($id_cost);
        echo json_encode($output);
    }
    if(isset($_POST['id_cost'])){
        getCostById1($_POST['id_cost']);
    }else{
		header('Location: 404erreur.php'); 
    }
?>