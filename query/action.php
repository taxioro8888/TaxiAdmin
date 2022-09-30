<?php 
    include("fonction.php");

    /* Start user */
    if((isset($_POST['id_user']) && !empty($_POST['id_user'])) 
    && (isset($_POST['nom_prenom']) && !empty($_POST['nom_prenom']))
    && (isset($_POST['email']) && !empty($_POST['email']))
    && (isset($_POST['mdp']) && !empty($_POST['mdp']))
    && (isset($_POST['telephone']) && !empty($_POST['telephone']))
    && (isset($_POST['statut']) && !empty($_POST['statut']))
    && (isset($_POST['categorie_user']) && !empty($_POST['categorie_user']))){
        $res = setUser($_POST['id_user'],$_POST['nom_prenom'],$_POST['email'],$_POST['mdp'],$_POST['statut'],$_POST['telephone'],$_POST['categorie_user']);
        if($res == 1){
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }else{
            $_SESSION['status'] = 2;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }

    if((isset($_POST['id_user_mod']) && !empty($_POST['id_user_mod'])) 
    && (isset($_POST['categorie_user_mod']) && !empty($_POST['categorie_user_mod']))
    && (isset($_POST['nom_prenom_mod']) && !empty($_POST['nom_prenom_mod']))
    && (isset($_POST['telephone_mod']) && !empty($_POST['telephone_mod']))
    && (isset($_POST['email_mod']) && !empty($_POST['email_mod']))
    && (isset($_POST['statut_mod']) && !empty($_POST['statut_mod']))){
        $res = setUserMod($_POST['id_user_mod'],$_POST['categorie_user_mod'],$_POST['nom_prenom_mod']
        ,$_POST['telephone_mod'],$_POST['email_mod'],$_POST['statut_mod']);
        // if($res == 1)
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_user']))){
        delUser($_GET['id_user']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_user_activer']))){
        enableUser($_GET['id_user_activer']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_user_desactiver']))){
        disableUser($_GET['id_user_desactiver']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    /* End user */

    /* Start notification */
    if((isset($_GET['id_notification']))){
        delNotification($_GET['id_notification']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    /* End notification */

    /* Start connexion */
    if((isset($_POST['email_sc']) && !empty($_POST['email_sc'])) 
    && (isset($_POST['mdp_sc']) && !empty($_POST['mdp_sc']))){
        $tab = array();
        $tab_user_info = array();
        $tab = setConnexion($_POST['email_sc'],$_POST['mdp_sc']);
        // $tab = setConnexion("admin@admin.com","admin");
        $res = $tab['res'];
        if(count($tab) != 0)
            $tab_user_info = $tab[0];

        if($res == 1){
            $_SESSION['user_info'] = $tab_user_info;
            $_SESSION['status'] = 1;
            header('Location: ../homex.php');
        }else{
            $_SESSION['status'] = 2;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }
    /* End connexion */

    /* Start change mdp */
    if((isset($_POST['anc_mdp']) && !empty($_POST['anc_mdp'])) 
    && (isset($_POST['new_mdp']) && !empty($_POST['new_mdp']))){
        $res = setChangeMdp($_POST['anc_mdp'],$_POST['new_mdp']);
        if($res == 1){
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }else{
            $_SESSION['status'] = 2;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }
    /* End change mdp */

    /* Start deconnexion */
    if(isset($_GET['logout']) && $_GET['logout'] == 'yes') {
        session_destroy();
        unset($_SESSION['user_info']);
        header('Location: ../index.php');
    }
    /* End deconnexion */

    /* Start catégorie utilisateur */
    if((isset($_POST['libelle_categorie_user']) && !empty($_POST['libelle_categorie_user']))){
        $res = setCategorieUser($_POST['libelle_categorie_user']);
        if($res == 1){
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }else{
            $_SESSION['status'] = 2;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }

    if((isset($_POST['id_categorie_user_mod']) && !empty($_POST['id_categorie_user_mod'])) 
    && (isset($_POST['libelle_categorie_user_mod']) && !empty($_POST['libelle_categorie_user_mod']))){
        $res = setCategorieUserMod($_POST['id_categorie_user_mod'],$_POST['libelle_categorie_user_mod']);
        // if($res == 1)
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_categorie_user']))){
        delCategorieUser($_GET['id_categorie_user']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    /* End catégorie utilisateur */

    /* Start type véhicule */
    if((isset($_POST['libelle_type_vehicule']) && !empty($_POST['libelle_type_vehicule']))
    && (isset($_POST['price_vehicule']) && !empty($_POST['price_vehicule']))
    && (isset($_FILES['image_vehicule']) && !empty($_FILES['image_vehicule']))){

        $temp = explode(".", $_FILES["image_vehicule"]["name"]);
        $newfile = 'image_vehicle_type'.'_'.microtime(true).'_'.rand(0,round(microtime(true)));
        $extension = '.'.end($temp);
        $newfilename = $newfile.''.$extension;
        
        $target_dir = '../assets/images/type_vehicle/';
        $target_file = $target_dir . basename($newfilename);
        $upload_ok = 1;
        $image_file_type = pathinfo($target_file,PATHINFO_EXTENSION);
        
        if($image_file_type == 'jpg' || $image_file_type == 'png' || $image_file_type == 'jpeg' || $image_file_type == 'gif'){
            $target_dir = "../assets/images/type_vehicle/";
            $target_file = $target_dir . basename($newfilename);
        }

        // Check file size
        if ($_FILES["image_vehicule"]["size"] > 10000000) { //10Mo
            //echo "File too big.";
            $upload_ok = 0;
        }
        // Limit allowed file formats
        if($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "JPG" && $image_file_type != "PNG" && $image_file_type != "JPEG") {
            //echo "Only JPG, JPEG, PNG & GIF files are allowed.";
            $upload_ok = 0;
        }
        // Check if $upload_ok is set to 0 by an error
        if ($upload_ok == 0) {
            echo "Your file was not uploaded.";
            $_SESSION['status'] = 3;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        // If all the checks are passed, file is uploaded
        } else {
            if (move_uploaded_file($_FILES["image_vehicule"]["tmp_name"], $target_file)) {
                //echo "The file ". basename($newfilename). " was uploaded.";
                
                $res = setTypeVehicule($_POST['libelle_type_vehicule'],$_POST['price_vehicule'],$newfilename);
                if($res == 1){
                    $_SESSION['status'] = 1;
                    header('Location: '.$_SERVER['HTTP_REFERER']);
                }else{
                    $_SESSION['status'] = 2;
                    header('Location: '.$_SERVER['HTTP_REFERER']);
                }
            } else {
                //echo "A error has occured uploading.";
                $_SESSION['status'] = 2;
                header('Location: '.$_SERVER['HTTP_REFERER']);
            }
        }
    }

    if((isset($_POST['id_type_vehicule_mod']) && !empty($_POST['id_type_vehicule_mod'])) 
    && (isset($_POST['libelle_type_vehicule_mod']) && !empty($_POST['libelle_type_vehicule_mod']))
    && (isset($_POST['price_vehicule_mod']) && !empty($_POST['price_vehicule_mod']))
    && (isset($_FILES['image_vehicule_mod']) && !empty($_FILES['image_vehicule_mod']))){
        
        $temp = explode(".", $_FILES["image_vehicule_mod"]["name"]);
        $newfile = 'image_vehicle_type'.'_'.microtime(true).'_'.rand(0,round(microtime(true)));
        $extension = '.'.end($temp);
        $newfilename = $newfile.''.$extension;
        
        $target_dir = '../assets/images/type_vehicle/';
        $target_file = $target_dir . basename($newfilename);
        $upload_ok = 1;
        $image_file_type = pathinfo($target_file,PATHINFO_EXTENSION);
        
        if($image_file_type == 'jpg' || $image_file_type == 'png' || $image_file_type == 'jpeg' || $image_file_type == 'gif'){
            $target_dir = "../assets/images/type_vehicle/";
            $target_file = $target_dir . basename($newfilename);
        }

        // Check file size
        if ($_FILES["image_vehicule_mod"]["size"] > 10000000) { //10Mo
            //echo "File too big.";
            $upload_ok = 0;
        }
        // Limit allowed file formats
        if($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "JPG" && $image_file_type != "PNG" && $image_file_type != "JPEG") {
            //echo "Only JPG, JPEG, PNG & GIF files are allowed.";
            $upload_ok = 0;
        }
        // Check if $upload_ok is set to 0 by an error
        if ($upload_ok == 0) {
            echo "Your file was not uploaded.";
            $_SESSION['status'] = 3;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        // If all the checks are passed, file is uploaded
        } else {
            if (move_uploaded_file($_FILES["image_vehicule_mod"]["tmp_name"], $target_file)) {
                //echo "The file ". basename($newfilename). " was uploaded.";
                
                $res = setTypeVehiculeMod($_POST['id_type_vehicule_mod'],$_POST['libelle_type_vehicule_mod'],$_POST['price_vehicule_mod'],$newfilename);
                // if($res == 1)
                    $_SESSION['status'] = 1;
                    header('Location: '.$_SERVER['HTTP_REFERER']);
            } else {
                //echo "A error has occured uploading.";
                $_SESSION['status'] = 2;
                header('Location: '.$_SERVER['HTTP_REFERER']);
            }
        }
    }

    if((isset($_GET['id_type_vehicule']))){
        delTypeVehicule($_GET['id_type_vehicule']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    /* End type véhicule */

    /* Start type véhicule */
    if((isset($_POST['libelle_type_vehicule_rental']) && !empty($_POST['libelle_type_vehicule_rental']))
    // && (isset($_POST['price_vehicule_rental']) && !empty($_POST['price_vehicule_rental']))
    && (isset($_FILES['image_vehicule_rental']) && !empty($_FILES['image_vehicule_rental']))){

        $temp = explode(".", $_FILES["image_vehicule_rental"]["name"]);
        $newfile = 'image_vehicle_type'.'_'.microtime(true).'_'.rand(0,round(microtime(true)));
        $extension = '.'.end($temp);
        $newfilename = $newfile.''.$extension;
        
        $target_dir = '../assets/images/type_vehicle_rental/';
        $target_file = $target_dir . basename($newfilename);
        $upload_ok = 1;
        $image_file_type = pathinfo($target_file,PATHINFO_EXTENSION);
        
        if($image_file_type == 'jpg' || $image_file_type == 'png' || $image_file_type == 'jpeg' || $image_file_type == 'gif'){
            $target_dir = "../assets/images/type_vehicle_rental/";
            $target_file = $target_dir . basename($newfilename);
        }

        // Check file size
        if ($_FILES["image_vehicule_rental"]["size"] > 10000000) { //10Mo
            //echo "File too big.";
            $upload_ok = 0;
        }
        // Limit allowed file formats
        if($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "JPG" && $image_file_type != "PNG" && $image_file_type != "JPEG") {
            //echo "Only JPG, JPEG, PNG & GIF files are allowed.";
            $upload_ok = 0;
        }
        // Check if $upload_ok is set to 0 by an error
        if ($upload_ok == 0) {
            echo "Your file was not uploaded.";
            $_SESSION['status'] = 3;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        // If all the checks are passed, file is uploaded
        } else {
            if (move_uploaded_file($_FILES["image_vehicule_rental"]["tmp_name"], $target_file)) {
                //echo "The file ". basename($newfilename). " was uploaded.";
                
                $res = setTypeVehiculeRental($_POST['libelle_type_vehicule_rental']/*,$_POST['price_vehicule_rental']*/,$newfilename);
                if($res == 1){
                    $_SESSION['status'] = 1;
                    header('Location: '.$_SERVER['HTTP_REFERER']);
                }else{
                    $_SESSION['status'] = 2;
                    header('Location: '.$_SERVER['HTTP_REFERER']);
                }
            } else {
                //echo "A error has occured uploading.";
                $_SESSION['status'] = 2;
                header('Location: '.$_SERVER['HTTP_REFERER']);
            }
        }
    }

    if((isset($_POST['id_type_vehicule_rental_mod']) && !empty($_POST['id_type_vehicule_rental_mod'])) 
    && (isset($_POST['libelle_type_vehicule_rental_mod']) && !empty($_POST['libelle_type_vehicule_rental_mod']))
    // && (isset($_POST['price_vehicule_rental_mod']) && !empty($_POST['price_vehicule_rental_mod']))
    && (isset($_FILES['image_vehicule_rental_mod']) && !empty($_FILES['image_vehicule_rental_mod']))){
        
        $temp = explode(".", $_FILES["image_vehicule_rental_mod"]["name"]);
        $newfile = 'image_vehicle_type'.'_'.microtime(true).'_'.rand(0,round(microtime(true)));
        $extension = '.'.end($temp);
        $newfilename = $newfile.''.$extension;
        
        $target_dir = '../assets/images/type_vehicle_rental/';
        $target_file = $target_dir . basename($newfilename);
        $upload_ok = 1;
        $image_file_type = pathinfo($target_file,PATHINFO_EXTENSION);
        
        if($image_file_type == 'jpg' || $image_file_type == 'png' || $image_file_type == 'jpeg' || $image_file_type == 'gif'){
            $target_dir = "../assets/images/type_vehicle_rental/";
            $target_file = $target_dir . basename($newfilename);
        }

        // Check file size
        if ($_FILES["image_vehicule_rental_mod"]["size"] > 10000000) { //10Mo
            //echo "File too big.";
            $upload_ok = 0;
        }
        // Limit allowed file formats
        if($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "JPG" && $image_file_type != "PNG" && $image_file_type != "JPEG") {
            //echo "Only JPG, JPEG, PNG & GIF files are allowed.";
            $upload_ok = 0;
        }
        // Check if $upload_ok is set to 0 by an error
        if ($upload_ok == 0) {
            echo "Your file was not uploaded.";
            $_SESSION['status'] = 3;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        // If all the checks are passed, file is uploaded
        } else {
            if (move_uploaded_file($_FILES["image_vehicule_rental_mod"]["tmp_name"], $target_file)) {
                //echo "The file ". basename($newfilename). " was uploaded.";
                
                $res = setTypeVehiculeRentalMod($_POST['id_type_vehicule_rental_mod'],$_POST['libelle_type_vehicule_rental_mod']/*,$_POST['price_vehicule_rental_mod']*/,$newfilename);
                // if($res == 1)
                    $_SESSION['status'] = 1;
                    header('Location: '.$_SERVER['HTTP_REFERER']);
            } else {
                //echo "A error has occured uploading.";
                $_SESSION['status'] = 2;
                header('Location: '.$_SERVER['HTTP_REFERER']);
            }
        }
    }

    if((isset($_GET['id_type_vehicule_rental']))){
        delTypeVehiculeRental($_GET['id_type_vehicule_rental']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    /* End type véhicule */

    /* Start currency */
    if((isset($_POST['libelle_currency']) && !empty($_POST['libelle_currency']))
    && (isset($_POST['symbole_currency']) && !empty($_POST['symbole_currency']))){
        $res = setCurrency($_POST['libelle_currency'],$_POST['symbole_currency']);
        if($res == 1){
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }else{
            $_SESSION['status'] = 2;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }

    if((isset($_POST['id_currency_mod']) && !empty($_POST['id_currency_mod'])) 
    && (isset($_POST['libelle_currency_mod']) && !empty($_POST['libelle_currency_mod']))
    && (isset($_POST['symbole_currency_mod']) && !empty($_POST['symbole_currency_mod']))){
        $res = setCurrencyMod($_POST['id_currency_mod'],$_POST['libelle_currency_mod'],$_POST['symbole_currency_mod']);
        // if($res == 1)
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_currency']))){
        delCurrency($_GET['id_currency']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_currency_activer']))){
        enableCurrency($_GET['id_currency_activer']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    /* End currency */

    /* Start country */
    if((isset($_POST['libelle_country']) && !empty($_POST['libelle_country']))
    && (isset($_POST['code_country']) && !empty($_POST['code_country']))){
        $res = setCountry($_POST['libelle_country'],$_POST['code_country']);
        if($res == 1){
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }else{
            $_SESSION['status'] = 2;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }

    if((isset($_POST['id_country_mod']) && !empty($_POST['id_country_mod'])) 
    && (isset($_POST['libelle_country_mod']) && !empty($_POST['libelle_country_mod']))
    && (isset($_POST['code_country_mod']) && !empty($_POST['code_country_mod']))){
        $res = setCountryMod($_POST['id_country_mod'],$_POST['libelle_country_mod'],$_POST['code_country_mod']);
        // if($res == 1)
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_country']))){
        delCountry($_GET['id_country']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_country_activer']))){
        enableCountry($_GET['id_country_activer']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    /* End country */

    /* Start commission */
    if((isset($_POST['libelle_commission']) && !empty($_POST['libelle_commission']))
    && (isset($_POST['value_commission']) && !empty($_POST['value_commission']))
    && (isset($_POST['type_commission']) && !empty($_POST['type_commission']))){
        $res = setCommission($_POST['libelle_commission'],$_POST['value_commission'],$_POST['type_commission']);
        if($res == 1){
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }else{
            $_SESSION['status'] = 2;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }

    if((isset($_POST['id_commission_mod']) && !empty($_POST['id_commission_mod'])) 
    && (isset($_POST['libelle_commission_mod']) && !empty($_POST['libelle_commission_mod']))
    && (isset($_POST['value_commission_mod']) && !empty($_POST['value_commission_mod']))
    && (isset($_POST['type_commission_mod']) && !empty($_POST['type_commission_mod']))){
        $res = setCommissionMod($_POST['id_commission_mod'],$_POST['libelle_commission_mod'],$_POST['value_commission_mod'],$_POST['type_commission_mod']);
        // if($res == 1)
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_POST['libelle_commission_perc']) && !empty($_POST['libelle_commission_perc']))
    && (isset($_POST['value_commission_perc']) && !empty($_POST['value_commission_perc']))
    && (isset($_POST['type_commission_perc']) && !empty($_POST['type_commission_perc']))){
        $res = setCommission($_POST['libelle_commission_perc'],$_POST['value_commission_perc'],$_POST['type_commission_perc']);
        if($res == 1){
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }else{
            $_SESSION['status'] = 2;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }

    if((isset($_POST['id_commission_mod_perc']) && !empty($_POST['id_commission_mod_perc'])) 
    && (isset($_POST['libelle_commission_mod_perc']) && !empty($_POST['libelle_commission_mod_perc']))
    && (isset($_POST['value_commission_mod_perc']) && !empty($_POST['value_commission_mod_perc']))
    && (isset($_POST['type_commission_mod_perc']) && !empty($_POST['type_commission_mod_perc']))){
        $res = setCommissionMod($_POST['id_commission_mod_perc'],$_POST['libelle_commission_mod_perc'],$_POST['value_commission_mod_perc'],$_POST['type_commission_mod_perc']);
        // if($res == 1)
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_commission']))){
        delCommission($_GET['id_commission']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_commission_activer']))){
        enableCommission($_GET['id_commission_activer']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_commission_desactiver']))){
        disableCommission($_GET['id_commission_desactiver']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    /* End commission */

    /* Start Payment Method */
    if((isset($_POST['libelle_method']) && !empty($_POST['libelle_method']))
    && (isset($_POST['status_method']) && !empty($_POST['status_method']))
    && (isset($_FILES['image_method']) && !empty($_FILES['image_method']))){
        
        $temp = explode(".", $_FILES["image_method"]["name"]);
        $newfile = 'image_method'.'_'.microtime(true).'_'.rand(0,round(microtime(true)));
        $extension = '.'.end($temp);
        $newfilename = $newfile.''.$extension;
        
        $target_dir = '../assets/images/payment_method/';
        $target_file = $target_dir . basename($newfilename);
        $upload_ok = 1;
        $image_file_type = pathinfo($target_file,PATHINFO_EXTENSION);
        
        if($image_file_type == 'jpg' || $image_file_type == 'png' || $image_file_type == 'jpeg' || $image_file_type == 'gif'){
            $target_dir = "../assets/images/payment_method/";
            $target_file = $target_dir . basename($newfilename);
        }

        // Check file size
        if ($_FILES["image_method"]["size"] > 10000000) { //10Mo
            //echo "File too big.";
            $upload_ok = 0;
        }
        // Limit allowed file formats
        if($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "JPG" && $image_file_type != "PNG" && $image_file_type != "JPEG") {
            //echo "Only JPG, JPEG, PNG & GIF files are allowed.";
            $upload_ok = 0;
        }
        // Check if $upload_ok is set to 0 by an error
        if ($upload_ok == 0) {
            echo "Your file was not uploaded.";
            $_SESSION['status'] = 3;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        // If all the checks are passed, file is uploaded
        } else {
            if (move_uploaded_file($_FILES["image_method"]["tmp_name"], $target_file)) {
                //echo "The file ". basename($newfilename). " was uploaded.";
                
                $res = setPaymentMethod($_POST['libelle_method'],$_POST['status_method'],$newfilename);
                if($res == 1){
                    $_SESSION['status'] = 1;
                    header('Location: '.$_SERVER['HTTP_REFERER']);
                }else{
                    $_SESSION['status'] = 2;
                    header('Location: '.$_SERVER['HTTP_REFERER']);
                }
            } else {
                //echo "A error has occured uploading.";
                $_SESSION['status'] = 2;
                header('Location: '.$_SERVER['HTTP_REFERER']);
            }
        }
    }

    if((isset($_POST['id_method_mod']) && !empty($_POST['id_method_mod'])) 
    && (isset($_POST['libelle_method_mod']) && !empty($_POST['libelle_method_mod']))
    && (isset($_POST['status_method_mod']) && !empty($_POST['status_method_mod']))
    && (isset($_FILES['image_method_mod']) && !empty($_FILES['image_method_mod']))){
        
        $temp = explode(".", $_FILES["image_method_mod"]["name"]);
        $newfile = 'image_method'.'_'.microtime(true).'_'.rand(0,round(microtime(true)));
        $extension = '.'.end($temp);
        $newfilename = $newfile.''.$extension;
        
        $target_dir = '../assets/images/payment_method/';
        $target_file = $target_dir . basename($newfilename);
        $upload_ok = 1;
        $image_file_type = pathinfo($target_file,PATHINFO_EXTENSION);
        
        if($image_file_type == 'jpg' || $image_file_type == 'png' || $image_file_type == 'jpeg' || $image_file_type == 'gif'){
            $target_dir = "../assets/images/payment_method/";
            $target_file = $target_dir . basename($newfilename);
        }

        // Check file size
        if ($_FILES["image_method_mod"]["size"] > 10000000) { //10Mo
            //echo "File too big.";
            $upload_ok = 0;
        }
        // Limit allowed file formats
        if($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "JPG" && $image_file_type != "PNG" && $image_file_type != "JPEG") {
            //echo "Only JPG, JPEG, PNG & GIF files are allowed.";
            $upload_ok = 0;
        }
        // Check if $upload_ok is set to 0 by an error
        if ($upload_ok == 0) {
            echo "Your file was not uploaded.";
            $_SESSION['status'] = 3;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        // If all the checks are passed, file is uploaded
        } else {
            if (move_uploaded_file($_FILES["image_method_mod"]["tmp_name"], $target_file)) {
                //echo "The file ". basename($newfilename). " was uploaded.";
                
                $res = setPaymentMethodMod($_POST['id_method_mod'],$_POST['libelle_method_mod'],$_POST['status_method_mod'],$newfilename);
                // if($res == 1)
                    $_SESSION['status'] = 1;
                    header('Location: '.$_SERVER['HTTP_REFERER']);
            } else {
                //echo "A error has occured uploading.";
                $_SESSION['status'] = 2;
                header('Location: '.$_SERVER['HTTP_REFERER']);
            }
        }
    }

    if((isset($_GET['id_method']))){
        delPaymentMethod($_GET['id_method']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_method_activer']))){
        enablePaymentMethod($_GET['id_method_activer']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_method_desactiver']))){
        disablePaymentMethod($_GET['id_method_desactiver']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    /* End Payment Method */

    /* Start Type taxi */
    /*if((isset($_POST['type_taxi']) && !empty($_POST['type_taxi']))
    && (isset($_POST['numero_taxi']) && !empty($_POST['numero_taxi']))
    && (isset($_POST['statut_taxi']) && !empty($_POST['statut_taxi']))
    && (isset($_POST['immatriculation_taxi']) && !empty($_POST['immatriculation_taxi']))){
        $res = setTaxi($_POST['type_taxi'],$_POST['numero_taxi'],$_POST['statut_taxi'],$_POST['immatriculation_taxi']);
        if($res == 1){
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }else{
            $_SESSION['status'] = 2;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }

    if((isset($_POST['id_taxi_mod']) && !empty($_POST['id_taxi_mod'])) 
    && (isset($_POST['type_taxi_mod']) && !empty($_POST['type_taxi_mod']))
    && (isset($_POST['numero_taxi_mod']) && !empty($_POST['numero_taxi_mod']))
    && (isset($_POST['immatriculation_taxi_mod']) && !empty($_POST['immatriculation_taxi_mod']))
    && (isset($_POST['statut_taxi_mod']) && !empty($_POST['statut_taxi_mod']))){
        $res = setTaxiMod($_POST['id_taxi_mod'],$_POST['type_taxi_mod']
        ,$_POST['numero_taxi_mod'],$_POST['immatriculation_taxi_mod'],$_POST['statut_taxi_mod']);
        // if($res == 1)
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_taxi']))){
        delTaxi($_GET['id_taxi']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_taxi_activer']))){
        enableTaxi($_GET['id_taxi_activer']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_taxi_desactiver']))){
        disableTaxi($_GET['id_taxi_desactiver']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }*/
    if((isset($_POST['libelle_type_taxi']) && !empty($_POST['libelle_type_taxi']))
    && (isset($_FILES['image_type_taxi']) && !empty($_FILES['image_type_taxi']))){
        
        $temp = explode(".", $_FILES["image_type_taxi"]["name"]);
        $newfile = 'image_taxi_type'.'_'.microtime(true).'_'.rand(0,round(microtime(true)));
        $extension = '.'.end($temp);
        $newfilename = $newfile.''.$extension;
        
        $target_dir = '../assets/images/taxi_type/';
        $target_file = $target_dir . basename($newfilename);
        $upload_ok = 1;
        $image_file_type = pathinfo($target_file,PATHINFO_EXTENSION);
        
        if($image_file_type == 'jpg' || $image_file_type == 'png' || $image_file_type == 'jpeg' || $image_file_type == 'gif'){
            $target_dir = "../assets/images/taxi_type/";
            $target_file = $target_dir . basename($newfilename);
        }

        // Check file size
        if ($_FILES["image_type_taxi"]["size"] > 10000000) { //10Mo
            //echo "File too big.";
            $upload_ok = 0;
        }
        // Limit allowed file formats
        if($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "JPG" && $image_file_type != "PNG" && $image_file_type != "JPEG") {
            //echo "Only JPG, JPEG, PNG & GIF files are allowed.";
            $upload_ok = 0;
        }
        // Check if $upload_ok is set to 0 by an error
        if ($upload_ok == 0) {
            echo "Your file was not uploaded.";
            $_SESSION['status'] = 3;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        // If all the checks are passed, file is uploaded
        } else {
            if (move_uploaded_file($_FILES["image_type_taxi"]["tmp_name"], $target_file)) {
                //echo "The file ". basename($newfilename). " was uploaded.";
                
                $res = setTypeTaxi($_POST['libelle_type_taxi'],$newfilename);
                if($res == 1){
                    $_SESSION['status'] = 1;
                    header('Location: '.$_SERVER['HTTP_REFERER']);
                }else{
                    $_SESSION['status'] = 2;
                    header('Location: '.$_SERVER['HTTP_REFERER']);
                }
            } else {
                //echo "A error has occured uploading.";
                $_SESSION['status'] = 2;
                header('Location: '.$_SERVER['HTTP_REFERER']);
            }
        }
    }

    if((isset($_POST['id_type_taxi_mod']) && !empty($_POST['id_type_taxi_mod'])) 
    && (isset($_POST['libelle_type_taxi_mod']) && !empty($_POST['libelle_type_taxi_mod']))){
        $res = setTypeTaxiMod($_POST['id_type_taxi_mod'],$_POST['libelle_type_taxi_mod']);
        // if($res == 1)
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_type_taxi']))){
        delTypeTaxi($_GET['id_type_taxi']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_type_taxi_activer']))){
        enableTypeTaxi($_GET['id_type_taxi_activer']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_type_taxi_desactiver']))){
        disableTypeTaxi($_GET['id_type_taxi_desactiver']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    /* End Type taxi */

    /* Start véhicule Rental*/
    if((isset($_POST['type_vehicule_rental']) && !empty($_POST['type_vehicule_rental']))
    && (isset($_POST['statut_vehicule_rental']) && !empty($_POST['statut_vehicule_rental']))
    && (isset($_POST['prix_vehicule_rental']) && !empty($_POST['prix_vehicule_rental']))
    && (isset($_POST['nb_place_vehicule_rental']) && !empty($_POST['nb_place_vehicule_rental']))
    && (isset($_POST['nombre_vehicule_rental']) && !empty($_POST['nombre_vehicule_rental']))
    /*&& (isset($_FILES['image_vehicule']) && !empty($_FILES['image_vehicule']))*/){
        
        /*$temp = explode(".", $_FILES["image_vehicule"]["name"]);
        $newfile = 'image_vehicule'.'_'.microtime(true).'_'.rand(0,round(microtime(true)));
        $extension = '.'.end($temp);
        $newfilename = $newfile.''.$extension;
        
        $target_dir = '../assets/images/vehicule/';
        $target_file = $target_dir . basename($newfilename);
        $upload_ok = 1;
        $image_file_type = pathinfo($target_file,PATHINFO_EXTENSION);
        
        if($image_file_type == 'jpg' || $image_file_type == 'png' || $image_file_type == 'jpeg' || $image_file_type == 'gif'){
            $target_dir = "../assets/images/vehicule/";
            $target_file = $target_dir . basename($newfilename);
        }

        // Check file size
        if ($_FILES["image_vehicule"]["size"] > 10000000) { //10Mo
            //echo "File too big.";
            $upload_ok = 0;
        }
        // Limit allowed file formats
        if($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "JPG" && $image_file_type != "PNG" && $image_file_type != "JPEG") {
            //echo "Only JPG, JPEG, PNG & GIF files are allowed.";
            $upload_ok = 0;
        }
        // Check if $upload_ok is set to 0 by an error
        if ($upload_ok == 0) {
            echo "Your file was not uploaded.";
            $_SESSION['status'] = 3;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        // If all the checks are passed, file is uploaded
        } else {
            if (move_uploaded_file($_FILES["image_vehicule"]["tmp_name"], $target_file)) {
                //echo "The file ". basename($newfilename). " was uploaded.";
                
            } else {
                //echo "A error has occured uploading.";
                $_SESSION['status'] = 2;
                header('Location: '.$_SERVER['HTTP_REFERER']);
            }
        }*/
        $res = setVehiculeRental($_POST['type_vehicule_rental'],$_POST['statut_vehicule_rental'],$_POST['prix_vehicule_rental']
        ,$_POST['nb_place_vehicule_rental']/*,$newfilename*/,$_POST['nombre_vehicule_rental']);
        if($res == 1){
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }else{
            $_SESSION['status'] = 2;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }

    if((isset($_POST['id_vehicule_rental_mod']) && !empty($_POST['id_vehicule_rental_mod'])) 
    && (isset($_POST['type_vehicule_rental_mod']) && !empty($_POST['type_vehicule_rental_mod']))
    && (isset($_POST['prix_vehicule_rental_mod']) && !empty($_POST['prix_vehicule_rental_mod']))
    && (isset($_POST['nb_place_vehicule_rental_mod']) && !empty($_POST['nb_place_vehicule_rental_mod']))
    // && (isset($_FILES['image_vehicule_rental_mod']) && !empty($_FILES['image_vehicule_rental_mod']))
    && (isset($_POST['nombre_vehicule_rental_mod']) && !empty($_POST['nombre_vehicule_rental_mod']))
    && (isset($_POST['statut_vehicule_rental_mod']) && !empty($_POST['statut_vehicule_rental_mod']))){

        /*$temp = explode(".", $_FILES["image_vehicule_mod"]["name"]);
        $newfile = 'image_vehicule'.'_'.microtime(true).'_'.rand(0,round(microtime(true)));
        $extension = '.'.end($temp);
        $newfilename = $newfile.''.$extension;
        
        $target_dir = '../assets/images/vehicule/';
        $target_file = $target_dir . basename($newfilename);
        $upload_ok = 1;
        $image_file_type = pathinfo($target_file,PATHINFO_EXTENSION);
        
        if($image_file_type == 'jpg' || $image_file_type == 'png' || $image_file_type == 'jpeg' || $image_file_type == 'gif'){
            $target_dir = "../assets/images/vehicule/";
            $target_file = $target_dir . basename($newfilename);
        }

        // Check file size
        if ($_FILES["image_vehicule_mod"]["size"] > 10000000) { //10Mo
            //echo "File too big.";
            $upload_ok = 0;
        }
        // Limit allowed file formats
        if($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg" && $image_file_type != "JPG" && $image_file_type != "PNG" && $image_file_type != "JPEG") {
            //echo "Only JPG, JPEG, PNG & GIF files are allowed.";
            $upload_ok = 0;
        }
        // Check if $upload_ok is set to 0 by an error
        if ($upload_ok == 0) {
            echo "Your file was not uploaded.";
            $_SESSION['status'] = 3;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        // If all the checks are passed, file is uploaded
        } else {
            if (move_uploaded_file($_FILES["image_vehicule_mod"]["tmp_name"], $target_file)) {
                //echo "The file ". basename($newfilename). " was uploaded.";
                
            } else {
                //echo "A error has occured uploading.";
                $_SESSION['status'] = 2;
                header('Location: '.$_SERVER['HTTP_REFERER']);
            }
        }*/
        $res = setVehiculeRentalMod($_POST['id_vehicule_rental_mod'],$_POST['type_vehicule_rental_mod']
        ,$_POST['statut_vehicule_rental_mod'],$_POST['prix_vehicule_rental_mod'],$_POST['nb_place_vehicule_rental_mod']/*,$newfilename*/,$_POST['nombre_vehicule_rental_mod']);
        // if($res == 1)
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_vehicule_rental']))){
        delVehiculeRental($_GET['id_vehicule_rental']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_vehicule_rental_activer']))){
        enableVehiculeRental($_GET['id_vehicule_rental_activer']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_vehicule_rental_desactiver']))){
        disableVehiculeRental($_GET['id_vehicule_rental_desactiver']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    /* End véhicule Rental */

    /* Start conducteur */
    if((isset($_POST['nom_conducteur']) && !empty($_POST['nom_conducteur']))
    && (isset($_POST['prenom_conducteur']) && !empty($_POST['prenom_conducteur']))
    && (isset($_POST['cnib_conducteur']) && !empty($_POST['cnib_conducteur']))
    && (isset($_POST['mdp_conducteur']) && !empty($_POST['mdp_conducteur']))
    && (isset($_POST['statut_conducteur']) && !empty($_POST['statut_conducteur']))
    && (isset($_POST['login_conducteur']) && !empty($_POST['login_conducteur']))){
        $res = setConducteur($_POST['nom_conducteur'],$_POST['prenom_conducteur'],$_POST['cnib_conducteur'],$_POST['statut_conducteur'],$_POST['login_conducteur'],$_POST['mdp_conducteur']);
        if($res == 1){
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }else{
            $_SESSION['status'] = 2;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }

    if((isset($_POST['id_conducteur_mod']) && !empty($_POST['id_conducteur_mod'])) 
    && (isset($_POST['nom_conducteur_mod']) && !empty($_POST['nom_conducteur_mod']))
    && (isset($_POST['prenom_conducteur_mod']) && !empty($_POST['prenom_conducteur_mod']))
    && (isset($_POST['cnib_conducteur_mod']) && !empty($_POST['cnib_conducteur_mod']))
    && (isset($_POST['login_conducteur_mod']) && !empty($_POST['login_conducteur_mod']))
    && (isset($_POST['statut_conducteur_mod']) && !empty($_POST['statut_conducteur_mod']))){
        $res = setConducteurMod($_POST['id_conducteur_mod'],$_POST['nom_conducteur_mod'],$_POST['prenom_conducteur_mod']
        ,$_POST['cnib_conducteur_mod'],$_POST['login_conducteur_mod'],$_POST['statut_conducteur_mod']);
        // if($res == 1)
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_conducteur']))){
        delConducteur($_GET['id_conducteur']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_conducteur_activer']))){
        enableConducteur($_GET['id_conducteur_activer']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_conducteur_desactiver']))){
        disableConducteur($_GET['id_conducteur_desactiver']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    /* End conducteur */

    /* Start affectation */
    if((isset($_POST['conducteur_affectation']) && !empty($_POST['conducteur_affectation']))
    && (isset($_POST['taxi_affectation']) && !empty($_POST['taxi_affectation']))
    && (isset($_POST['statut_affectation']) && !empty($_POST['statut_affectation']))){
        $res = setAffectation($_POST['conducteur_affectation'],$_POST['taxi_affectation'],$_POST['statut_affectation']);
        if($res == 1){
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }else{
            $_SESSION['status'] = 2;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }

    if((isset($_POST['id_affectation_mod']) && !empty($_POST['id_affectation_mod'])) 
    && (isset($_POST['conducteur_affectation_mod']) && !empty($_POST['conducteur_affectation_mod']))
    && (isset($_POST['taxi_affectation_mod']) && !empty($_POST['taxi_affectation_mod']))
    && (isset($_POST['statut_affectation_mod']) && !empty($_POST['statut_affectation_mod']))){
        $res = setAffectationMod($_POST['id_affectation_mod'],$_POST['conducteur_affectation_mod'],$_POST['taxi_affectation_mod']
        ,$_POST['statut_affectation_mod']);
        // if($res == 1)
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_affectation']))){
        delAffectation($_GET['id_affectation']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_affectation_activer']))){
        enableAffectation($_GET['id_affectation_activer']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }

    if((isset($_GET['id_affectation_desactiver']))){
        disableAffectation($_GET['id_affectation_desactiver']);
        $_SESSION['status'] = 1;
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
    /* End affectation */

    /* Start settings */
    if((isset($_POST['setting_title']) && !empty($_POST['setting_title']))
    && (isset($_POST['setting_footer']) && !empty($_POST['setting_footer']))
    && (isset($_POST['setting_email']) && !empty($_POST['setting_email']))){
        $res = setSettings($_POST['setting_title'],$_POST['setting_footer'],$_POST['setting_email']);
        if($res == 1){
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }else{
            $_SESSION['status'] = 2;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }
    /* End settings */

    /* Start Location */
        if((isset($_GET['id_location']))){
            delLocation($_GET['id_location']);
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }

        if((isset($_GET['id_location_activer']))){
            enableLocation($_GET['id_location_activer']);
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }

        if((isset($_GET['id_location_desactiver']))){
            disableLocation($_GET['id_location_desactiver']);
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }

        if((isset($_GET['id_location_cloturer']))){
            closeLocation($_GET['id_location_cloturer']);
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    /* End Location */

    /* Start Réservation */
        if((isset($_GET['id_reservation']))){
            delReservation($_GET['id_reservation']);
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }

        if((isset($_GET['id_reservation_activer']))){
            enableReservation($_GET['id_reservation_activer']);
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }

        if((isset($_GET['id_reservation_desactiver']))){
            disableReservation($_GET['id_reservation_desactiver']);
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }

        if((isset($_GET['id_reservation_cloturer']))){
            closeReservation($_GET['id_reservation_cloturer']);
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    /* End Réservation */

    /* Start User app */
        if((isset($_GET['id_user_app']))){
            delUserApp($_GET['id_user_app']);
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }

        if((isset($_GET['id_user_app_activer']))){
            enableUserApp($_GET['id_user_app_activer']);
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }

        if((isset($_GET['id_user_app_desactiver']))){
            disableUserApp($_GET['id_user_app_desactiver']);
            $_SESSION['status'] = 1;
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    /* End User app */
?>