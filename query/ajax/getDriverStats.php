<?php 
	include('../fonction.php');
    function getDriverStats1($id_driver,$month,$year){
        $output[] = array();
        $output = getDriverStats($id_driver,$month,$year);
        echo json_encode($output);
    }
    if(isset($_POST['id_driver'],$_POST['month'],$_POST['year'])){
        getDriverStats1($_POST['id_driver'],$_POST['month'],$_POST['year']);
    }else{
		header('Location: 404erreur.php'); 
    }
?>