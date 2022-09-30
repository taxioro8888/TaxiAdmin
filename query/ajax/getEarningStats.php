<?php 
	include('../fonction.php');
    function getEarningStats1($month,$year){
        $output[] = array();
        $output = getEarningStats($month,$year);
        echo json_encode($output);
    }
    if(isset($_POST['month'],$_POST['year'])){
        getEarningStats1($_POST['month'],$_POST['year']);
    }else{
		header('Location: 404erreur.php'); 
    }
?>