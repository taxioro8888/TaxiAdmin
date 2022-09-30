<?php 
	include('../fonction.php');
    function getCommissionById1($id_commission){
        $output[] = array();
        $output = getCommissionById($id_commission);
        echo json_encode($output);
    }
    if(isset($_POST['id_commission'])){
        getCommissionById1($_POST['id_commission']);
    }else{
		header('Location: 404erreur.php'); 
    }
?>