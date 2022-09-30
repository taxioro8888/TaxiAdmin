<?php 
	include('../fonction.php');
    function getCustomerStats1($id_customer,$month,$year){
        $output[] = array();
        $output = getCustomerStats($id_customer,$month,$year);
        echo json_encode($output);
    }
    if(isset($_POST['id_customer'],$_POST['month'],$_POST['year'])){
        getCustomerStats1($_POST['id_customer'],$_POST['month'],$_POST['year']);
    }else{
		header('Location: 404erreur.php'); 
    }
?>