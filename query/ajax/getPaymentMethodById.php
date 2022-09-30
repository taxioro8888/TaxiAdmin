<?php 
	include('../fonction.php');
    function getPaymentMethodById1($id_method){
        $output[] = array();
        $output = getPaymentMethodById($id_method);
        echo json_encode($output);
    }
    if(isset($_POST['id_method'])){
        getPaymentMethodById1($_POST['id_method']);
    }else{
		header('Location: 404erreur.php'); 
    }
?>