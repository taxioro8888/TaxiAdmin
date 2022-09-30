<?php 
	include('../fonction.php');
    function getEarningStatsDashboard1($year){
        $output[] = array();
        $output = getEarningStatsDashboard($year);
        echo json_encode($output);
    }
    if(isset($_POST['year'])){
        getEarningStatsDashboard1($_POST['year']);
    }else{
		header('Location: 404erreur.php'); 
    }
?>