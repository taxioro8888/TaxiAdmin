<?php
    session_start();
	date_default_timezone_set ('Africa/Ouagadougou');
    include("connexion.php");
    $con->set_charset("utf8");
	require_once('php_image_magician.php');

    /* Start User */
    function setUser($id,$nom_prenom,$email,$mdp,$statut,$telephone,$categorie_user){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $nom_prenom = str_replace("'","\'",$nom_prenom);
        $email = str_replace("'","\'",$email);
        $mdp = str_replace("'","\'",$mdp);
        $statut = str_replace("'","\'",$statut);
        $date_heure = date('Y-m-d H:i:s');

        $mdp = md5($mdp);

        $sql_verif = "SELECT id FROM tj_user WHERE email='$email' AND mdp='$mdp'";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_user (id, nom_prenom, email, mdp, creer, statut, telephone, id_categorie_user)
            VALUES ($id,'$nom_prenom', '$email', '$mdp', '$date_heure', '$statut', '$telephone', $categorie_user)";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }

    function setUserMod($id,$id_user_cat,$nom_prenom,$phone,$email,$statut){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $nom_prenom = str_replace("'","\'",$nom_prenom);
        $phone = str_replace("'","\'",$phone);
        $email = str_replace("'","\'",$email);
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_user SET nom_prenom='$nom_prenom', telephone='$phone', email='$email', statut='$statut', id_categorie_user=$id_user_cat WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }

    function getUser(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT u.id,u.nom_prenom,u.telephone,u.email,u.statut,u.creer,u.modifier,c.libelle as libCatUser
        FROM tj_user u, tj_categorie_user c
        WHERE u.id_categorie_user=c.id";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function delUser($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_user WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function enableUser($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_user SET statut='yes' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function disableUser($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_user SET statut='no' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function getLastUser(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_user ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getUserById($id_user){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT u.id,u.nom_prenom,u.telephone,u.email,u.statut,u.creer,u.modifier,u.id_categorie_user,c.libelle as libCatUser
        FROM tj_user u, tj_categorie_user c
        WHERE u.id_categorie_user=c.id AND u.id=$id_user";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }
    /* End User */

    /* Start notification */
    function getNotification(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_notification";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function delNotification($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_notification WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }
    /* End notification */

    /* Start Connexion */
    function setConnexion($email,$mdp){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $email = str_replace("'","\'",$email);
        $mdp = str_replace("'","\'",$mdp);
        $date_heure = date('Y-m-d H:i:s');

        $mdp = md5($mdp);

        $sql_verif = "SELECT u.id,u.nom_prenom,u.telephone,u.email,u.statut,u.creer,u.modifier,c.libelle as libCatUser
        FROM tj_user u, tj_categorie_user c
        WHERE u.id_categorie_user=c.id AND u.email='$email' AND u.mdp='$mdp' AND u.statut='yes'";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            // output data of each row
            while($row = mysqli_fetch_assoc($result_verif)) {
                $output[] = $row;
            }
            $output['res'] = '1';
        }else{
            $output['res'] = '2';
        }
        mysqli_close($con);
        return $output;
    }
    /* End Connexion */

    /* Start Categorie User */
    function setCategorieUser($libelle){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $libelle = str_replace("'","\'",$libelle);
        $date_heure = date('Y-m-d H:i:s');

        $sql_verif = "SELECT id FROM tj_categorie_user WHERE libelle='$libelle'";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_categorie_user (libelle, creer) VALUES ('$libelle', '$date_heure')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }

    function setCategorieUserMod($id,$categorie){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $nom_prenom = str_replace("'","\'",$nom_prenom);
        $telephone = str_replace("'","\'",$telephone);
        $email = str_replace("'","\'",$email);
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_categorie_user SET libelle='$categorie' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }

    function getCategorieUser(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_categorie_user";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getCategorieUserById($id_categorie){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_categorie_user WHERE id=$id_categorie";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getIdCategorieUserByLibelle($lib_annee){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT id FROM tj_categorie_user WHERE libelle='$lib_annee'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
        }
        
        mysqli_close($con);
        return $id;
    }

    function delCategorieUser($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_categorie_user WHERE id=$id";
        $result = mysqli_query($con,$sql);
        mysqli_close($con);
    }

    function getLastCategorieUser(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_categorie_user ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }
    /* End Categorie User */

    /* Start Type véhicule */
    function setTypeVehicule($libelle,$prix,$image){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $libelle = str_replace("'","\'",$libelle);
        $prix = str_replace("'","\'",$prix);
        $date_heure = date('Y-m-d H:i:s');

        $sql_verif = "SELECT id FROM tj_type_vehicule WHERE libelle='$libelle'";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_type_vehicule (libelle, creer, prix, image) VALUES ('$libelle', '$date_heure', '$prix', '$image')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }

    function setTypeVehiculeMod($id,$libelle,$prix,$image){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $libelle = str_replace("'","\'",$libelle);
        $prix = str_replace("'","\'",$prix);
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_type_vehicule SET image='$image', libelle='$libelle', prix='$prix', modifier='$date_heure' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }


    function getTypeVehicule(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_type_vehicule";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getTypeVehiculeById($id_type){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_type_vehicule WHERE id=$id_type";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getIdTypeVehiculeByLibelle($lib_annee){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT id FROM tj_type_vehicule WHERE libelle='$lib_annee'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
        }
        
        mysqli_close($con);
        return $id;
    }

    function delTypeVehicule($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_type_vehicule WHERE id=$id";
        $result = mysqli_query($con,$sql);
        mysqli_close($con);
    }

    function getLastTypeVehicule(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_type_vehicule ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }
    /* End Type véhicule */

    /* Start Type véhicule rental */
    function setTypeVehiculeRental($libelle,$image){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $libelle = str_replace("'","\'",$libelle);
        // $prix = str_replace("'","\'",$prix);
        $date_heure = date('Y-m-d H:i:s');

        $sql_verif = "SELECT id FROM tj_type_vehicule_rental WHERE libelle='$libelle'";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_type_vehicule_rental (libelle, creer, image) VALUES ('$libelle', '$date_heure', '$image')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }

    function setTypeVehiculeRentalMod($id,$libelle/*,$prix*/,$image){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $libelle = str_replace("'","\'",$libelle);
        // $prix = str_replace("'","\'",$prix);
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_type_vehicule_rental SET image='$image', libelle='$libelle', modifier='$date_heure' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }


    function getTypeVehiculeRental(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_type_vehicule_rental";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getTypeVehiculeRentalById($id_type){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_type_vehicule_rental WHERE id=$id_type";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getIdTypeVehiculeRentalByLibelle($lib_annee){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT id FROM tj_type_vehicule_rental WHERE libelle='$lib_annee'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
        }
        
        mysqli_close($con);
        return $id;
    }

    function delTypeVehiculeRental($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_type_vehicule_rental WHERE id=$id";
        $result = mysqli_query($con,$sql);
        mysqli_close($con);
    }

    function getLastTypeVehiculeRental(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_type_vehicule_rental ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }
    /* End Type véhicule rental */

    /* Start Currency */
    function setCurrency($libelle,$symbole){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $libelle = str_replace("'","\'",$libelle);
        $symbole = str_replace("'","\'",$symbole);
        $date_heure = date('Y-m-d H:i:s');

        $sql_verif = "SELECT id FROM tj_currency WHERE libelle='$libelle'";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_currency (libelle, symbole, statut, creer) 
            VALUES ('$libelle', '$symbole', 'no', '$date_heure')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }

    function setCurrencyMod($id,$libelle,$symbole){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $libelle = str_replace("'","\'",$libelle);
        $symbole = str_replace("'","\'",$symbole);
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_currency SET libelle='$libelle', symbole='$symbole', modifier='$date_heure' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }

    function getCurrency(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_currency";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getEnabledCurrency(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_currency WHERE statut='yes'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getCurrencyById($id_type){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_currency WHERE id=$id_type";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getIdCurrencyByLibelle($lib_annee){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT id FROM tj_currency WHERE libelle='$lib_annee'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
        }
        
        mysqli_close($con);
        return $id;
    }

    function delCurrency($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_currency WHERE id=$id";
        $result = mysqli_query($con,$sql);
        mysqli_close($con);
    }

    function getLastCurrency(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_currency ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function enableCurrency($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_currency SET statut='yes' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        $sql = "UPDATE tj_currency SET statut='no' WHERE id!=$id";
        $result = mysqli_query($con,$sql);
    }
    /* End Currency */

    /* Start Country */
    function setCountry($libelle,$code){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $libelle = str_replace("'","\'",$libelle);
        $code = str_replace("'","\'",$code);
        $date_heure = date('Y-m-d H:i:s');

        $sql_verif = "SELECT id FROM tj_country WHERE libelle='$libelle'";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_country (libelle, code, statut, creer) 
            VALUES ('$libelle', '$code', 'no', '$date_heure')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }

    function setCountryMod($id,$libelle,$code){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $libelle = str_replace("'","\'",$libelle);
        $code = str_replace("'","\'",$code);
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_country SET libelle='$libelle', code='$code', modifier='$date_heure' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }

    function getCountry(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_country ORDER BY id ASC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getEnabledCountry(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_country WHERE statut='yes'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getCountryById($id_country){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_country WHERE id=$id_country";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getIdCountryByLibelle($lib_annee){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT id FROM tj_country WHERE libelle='$lib_annee'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
        }
        
        mysqli_close($con);
        return $id;
    }

    function delCountry($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_country WHERE id=$id";
        $result = mysqli_query($con,$sql);
        mysqli_close($con);
    }

    function getLastCountry(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_country ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function enableCountry($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_country SET statut='yes' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        $sql = "UPDATE tj_country SET statut='no' WHERE id!=$id";
        $result = mysqli_query($con,$sql);
    }
    /* End Country */

    /* Start Commission */
    function setCommission($libelle,$value,$type){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $libelle = str_replace("'","\'",$libelle);
        $value = str_replace("'","\'",$value);
        $type = str_replace("'","\'",$type);
        $date_heure = date('Y-m-d H:i:s');

        $sql_verif = "SELECT id FROM tj_commission WHERE libelle='$libelle'";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_commission (libelle, value, statut, creer, type) 
            VALUES ('$libelle', '$value', 'yes', '$date_heure', '$type')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }

    function setCommissionMod($id,$libelle,$value,$type){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $libelle = str_replace("'","\'",$libelle);
        $value = str_replace("'","\'",$value);
        $type = str_replace("'","\'",$type);
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_commission SET libelle='$libelle', value='$value', modifier='$date_heure', type='$type' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }

    function getCommission(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_commission";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getCommissionFixed(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_commission WHERE type='Fixed'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getCommissionPerc(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_commission WHERE type='Percentage'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getEnabledCommission(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_commission WHERE statut='yes'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getCommissionById($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_commission WHERE id=$id";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getIdCommissionByLibelle($lib_annee){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT id FROM tj_commission WHERE libelle='$lib_annee'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
        }
        
        mysqli_close($con);
        return $id;
    }

    function delCommission($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_commission WHERE id=$id";
        $result = mysqli_query($con,$sql);
        mysqli_close($con);
    }

    function getLastCommission(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_commission ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function enableCommission($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_commission SET statut='yes' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function disableCommission($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_commission SET statut='no' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }
    /* End Commission */

    /* Start Payment Method */
    function setPaymentMethod($libelle,$statut,$image){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $libelle = str_replace("'","\'",$libelle);
        $statut = str_replace("'","\'",$statut);
        $image = str_replace("'","\'",$image);
        $date_heure = date('Y-m-d H:i:s');

        $sql_verif = "SELECT id FROM tj_payment_method WHERE libelle='$libelle'";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_payment_method (libelle, statut, creer, image) 
            VALUES ('$libelle', '$statut', '$date_heure', '$image')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }

    function setPaymentMethodMod($id,$libelle,$statut,$image){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $libelle = str_replace("'","\'",$libelle);
        $statut = str_replace("'","\'",$statut);
        $image = str_replace("'","\'",$image);
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_payment_method SET libelle='$libelle', statut='$statut', modifier='$date_heure', image='$image' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }

    function getPaymentMethod(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_payment_method";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getEnabledPaymentMethod(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_payment_method WHERE statut='yes'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getPaymentMethodById($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_payment_method WHERE id=$id";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getIdPaymentMethodByLibelle($lib_annee){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT id FROM tj_payment_method WHERE libelle='$lib_annee'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
        }
        
        mysqli_close($con);
        return $id;
    }

    function delPaymentMethod($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_payment_method WHERE id=$id";
        $result = mysqli_query($con,$sql);
        mysqli_close($con);
    }

    function getLastPaymentMethod(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_payment_method ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function enablePaymentMethod($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_payment_method SET statut='yes' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function disablePaymentMethod($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_payment_method SET statut='no' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }
    /* End Payment Method */

    /* Start Taxi */
    function setTaxi($type_vehicule,$numero,$statut,$immatriculation){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $numero = str_replace("'","\'",$numero);
        $immatriculation = str_replace("'","\'",$immatriculation);
        $date_heure = date('Y-m-d H:i:s');

        $sql_verif = "SELECT id FROM tj_taxi WHERE numero='$numero'";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_taxi (numero, immatriculation, statut, id_type_vehicule, creer) VALUES ('$numero', '$immatriculation', '$statut', $type_vehicule, '$date_heure')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }

    function setTaxiMod($id,$type_vehicule,$numero,$immatriculation,$statut){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $numero = str_replace("'","\'",$numero);
        $immatriculation = str_replace("'","\'",$immatriculation);
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_taxi SET id_type_vehicule='$type_vehicule', numero='$numero', immatriculation='$immatriculation', statut='$statut', modifier='$date_heure' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }

    function getTaxi(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT v.id,v.numero,v.immatriculation,v.statut,v.creer,v.modifier,tv.libelle as libTypeVehicule
        FROM tj_taxi v, tj_type_vehicule tv
        WHERE v.id_type_vehicule=tv.id";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getTaxiById($id_taxi){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_taxi WHERE id=$id_taxi";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getIdTaxiByLibelle($lib_annee){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT id FROM tj_taxi WHERE libelle='$lib_annee'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
        }
        
        mysqli_close($con);
        return $id;
    }

    function delTaxi($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_taxi WHERE id=$id";
        $result = mysqli_query($con,$sql);
        mysqli_close($con);
    }

    function enableTaxi($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_taxi SET statut='yes' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function disableTaxi($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_taxi SET statut='no' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function getLastTaxi(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_taxi ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }
    /* End Taxi */

    /* Start Type Taxi */
    function setTypeTaxi($libelle,$image){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $libelle = str_replace("'","\'",$libelle);
        $date_heure = date('Y-m-d H:i:s');

        $sql_verif = "SELECT id FROM tj_taxi_type WHERE libelle='$libelle'";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_taxi_type (libelle, image, statut, creer) VALUES ('$libelle', '$image', 'yes', '$date_heure')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }

    function setTypeTaxiMod($id,$libelle){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $libelle = str_replace("'","\'",$libelle);
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_taxi_type SET libelle='$libelle', modifier='$date_heure' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }

    function getTypeTaxi(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_taxi_type";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getTypeTaxiById($id_taxi){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_taxi_type WHERE id=$id_taxi";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getIdTypeTaxiByLibelle($lib_annee){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT id FROM tj_taxi_type WHERE libelle='$lib_annee'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
        }
        
        mysqli_close($con);
        return $id;
    }

    function delTypeTaxi($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_taxi_type WHERE id=$id";
        $result = mysqli_query($con,$sql);
        mysqli_close($con);
    }

    function enableTypeTaxi($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_taxi_type SET statut='yes' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function disableTypeTaxi($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_taxi_type SET statut='no' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function getLastTypeTaxi(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_taxi_type ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }
    /* End Type Taxi */

    /* Start Véhicule */
    function setVehicule($type_vehicule,$statut,$prix,$nb_place,$image,$nombre){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $date_heure = date('Y-m-d H:i:s');

        $sql_verif = "SELECT id FROM tj_vehicule WHERE id_type_vehicule=$type_vehicule";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_vehicule (nombre, statut, prix, nb_place, image, id_type_vehicule, creer)
            VALUES ('$nombre', '$statut', $prix, $nb_place, '$image', $type_vehicule, '$date_heure')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }

    function setVehiculeMod($id,$type_vehicule,$statut,$prix,$nb_place,$image,$nombre){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_vehicule SET id_type_vehicule='$type_vehicule', nombre='$nombre', statut='$statut', prix=$prix, nb_place=$nb_place, image='$image', modifier='$date_heure' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }

    function getVehicule(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT v.id,v.nombre,v.image,v.statut,v.prix,v.nb_place,v.creer,v.modifier,tv.libelle as libTypeVehicule
        FROM tj_vehicule v, tj_type_vehicule tv
        WHERE v.id_type_vehicule=tv.id";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getVehiculeById($id_vehicule){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_vehicule WHERE id=$id_vehicule";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getVehiculeByDriverId($id_driver){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_vehicule WHERE id_conducteur=$id_driver";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getIdVehiculeByLibelle($lib_annee){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT id FROM tj_vehicule WHERE libelle='$lib_annee'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
        }
        
        mysqli_close($con);
        return $id;
    }

    function delVehicule($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_vehicule WHERE id=$id";
        $result = mysqli_query($con,$sql);
        mysqli_close($con);
    }

    function enableVehicule($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_vehicule SET statut='yes' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function disableVehicule($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_vehicule SET statut='no' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function getLastVehicule(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_vehicule ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }
    /* End Véhicule */

    /* Start Véhicule Rental */
    function setVehiculeRental($type_vehicule,$statut,$prix,$nb_place/*,$image*/,$nombre){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $date_heure = date('Y-m-d H:i:s');

        $sql_verif = "SELECT id FROM tj_vehicule_rental WHERE id_type_vehicule_rental=$type_vehicule";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_vehicule_rental (nombre, statut, prix, nb_place, id_type_vehicule_rental, creer)
            VALUES ('$nombre', '$statut', $prix, $nb_place, $type_vehicule, '$date_heure')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }

    function setVehiculeRentalMod($id,$type_vehicule,$statut,$prix,$nb_place/*,$image*/,$nombre){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_vehicule_rental SET id_type_vehicule_rental='$type_vehicule', nombre='$nombre', statut='$statut', prix=$prix, nb_place=$nb_place, modifier='$date_heure' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }

    function getVehiculeRental(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT v.id,v.nombre,tv.image,v.statut,v.prix,v.nb_place,v.creer,v.modifier,tv.libelle as libTypeVehicule
        FROM tj_vehicule_rental v, tj_type_vehicule_rental tv
        WHERE v.id_type_vehicule_rental=tv.id";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getVehiculeRentalById($id_vehicule){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_vehicule_rental WHERE id=$id_vehicule";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getVehiculeRentalByDriverId($id_driver){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_vehicule_rental WHERE id_conducteur=$id_driver";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getIdVehiculeRentalByLibelle($lib_annee){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT id FROM tj_vehicule_rental WHERE libelle='$lib_annee'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
        }
        
        mysqli_close($con);
        return $id;
    }

    function delVehiculeRental($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_vehicule_rental WHERE id=$id";
        $result = mysqli_query($con,$sql);
        mysqli_close($con);
    }

    function enableVehiculeRental($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_vehicule_rental SET statut='yes' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function disableVehiculeRental($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_vehicule_rental SET statut='no' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function getLastVehiculeRental(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_vehicule_rental ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }
    /* End Véhicule Rental */

    /* Start Conducteur */
    function setConducteur($nom,$prenom,$cnib,$statut,$login,$mdp){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $nom = str_replace("'","\'",$nom);
        $prenom = str_replace("'","\'",$prenom);
        $cnib = str_replace("'","\'",$cnib);
        $login = str_replace("'","\'",$login);
        $mdp = str_replace("'","\'",$mdp);
        $date_heure = date('Y-m-d H:i:s');

        $mdp = md5($mdp);

        $sql_verif = "SELECT id FROM tj_conducteur WHERE phone='$login' AND mdp='$mdp'";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_conducteur (nom, prenom, cnib, phone, mdp, statut, creer, online) VALUES ('$nom', '$prenom', '$cnib', '$login', '$mdp', '$statut', '$date_heure', 'yes')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }

    function setConducteurMod($id,$nom,$prenom,$cnib,$login,$statut){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $nom = str_replace("'","\'",$nom);
        $prenom = str_replace("'","\'",$prenom);
        $cnib = str_replace("'","\'",$cnib);
        $login = str_replace("'","\'",$login);
        $statut = str_replace("'","\'",$statut);
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_conducteur SET nom='$nom', prenom='$prenom', cnib='$cnib', phone='$login', statut='$statut', modifier='$date_heure' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }

    function getConducteur(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_conducteur";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getConducteurDisabled(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_conducteur WHERE statut='no'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getConducteurById($id_conducteur){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_conducteur WHERE id=$id_conducteur";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getIdConducteurByLibelle($lib_annee){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT id FROM tj_conducteur WHERE libelle='$lib_annee'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
        }
        
        mysqli_close($con);
        return $id;
    }

    function delConducteur($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_conducteur WHERE id=$id";
        $result = mysqli_query($con,$sql);
        mysqli_close($con);
    }

    function enableConducteur($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_conducteur SET statut='yes' WHERE id=$id";
        $result = mysqli_query($con,$sql);

        $sql = "SELECT nom, prenom, email FROM tj_conducteur WHERE id='$id'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $nom = "";
        $prenom = "";
        $email = "";
        while($row = mysqli_fetch_assoc($result)) {
            $nom = $row['nom'];
            $prenom = $row['prenom'];
            $email = $row['email'];
        }
        
        $to = $email;
        $subject = "Confirmación de su cuenta | Taxi uber - Taxi a pedido";
        $message = '
            <body style="margin:100px; background: #f8f8f8; ">
                <div width="100%" style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
                    <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px; background: #fff;">
                        <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">
                            <tbody>
                                <tr>
                                    <td style="vertical-align: top; padding-bottom:30px;" align="center">
                                        <img src="http://projets.hevenbf.com/yellow%20taxi/webservices/images/logo_taxijaune.jpg" alt="logo Taxi Jaune" style="border:none" width="15%">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="padding: 40px; background: #fff;">
                            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <h3>Confirmación de su cuenta </h3>
                                        <p>Hola '.$prenom.' '.$nom.'</p>
                                        <b>nos complace informarle que su cuenta ha sido aprobada con éxito. Ahora es un miembro pleno y registrado de Taxi Uber y puede iniciar sesión ahora y comenzar a recoger pasajeros y ganar mucho dinero.</b><br>
                                        <p>¡Buena continuación y hasta pronto!</p>
                                        <p>Taxi Uber - </p>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </body>
        ';
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\b";
        $headers .= 'From: Taxi Cab - On Demand Taxi' . "\r\n";
        mail($to,$subject,$message,$headers);
    }

    function disableConducteur($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_conducteur SET statut='no' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function getLastConducteur(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_conducteur ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }
    /* End Conducteur */

    /* Start All Vehicle */
    function getAllVehicle(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT v.id,v.brand,v.model,v.color,v.numberplate,v.statut,c.latitude,c.longitude,v.creer,v.modifier,c.nom,c.prenom,c.phone,c.online
        FROM tj_vehicule v, tj_conducteur c
        WHERE v.id_conducteur=c.id AND v.statut='yes' AND c.longitude!='' AND c.latitude!=''";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }

        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }
    /* End All vehicle */

    /* Start Affectation */
    function setAffectation($conducteur,$vehicule,$statut){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $date_heure = date('Y-m-d H:i:s');

        $mdp = md5($mdp);

        $sql_verif = "SELECT id FROM tj_affectation WHERE id_taxi='$vehicule'";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_affectation (id_taxi, id_conducteur, statut, creer) VALUES ('$vehicule', '$conducteur', '$statut', '$date_heure')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }

    function setAffectationMod($id,$id_conducteur,$id_taxi,$statut){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_affectation SET id_conducteur=$id_conducteur, id_taxi=$id_taxi, statut='$statut', modifier='$date_heure' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }

    function getAffectation(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT a.id,a.statut,a.creer,a.modifier,v.numero,c.nom,c.prenom,v.id as idTaxi,c.id as idConducteur
        FROM tj_affectation a, tj_taxi v, tj_conducteur c
        WHERE a.id_taxi=v.id AND a.id_conducteur=c.id";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getAffectationById($id_affectation){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_affectation WHERE id=$id_affectation";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getIdAffectationByLibelle($lib_annee){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT id FROM tj_affectation WHERE libelle='$lib_annee'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
        }
        
        mysqli_close($con);
        return $id;
    }

    function delAffectation($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_affectation WHERE id=$id";
        $result = mysqli_query($con,$sql);
        mysqli_close($con);
    }

    function enableAffectation($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_affectation SET statut='yes' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function disableAffectation($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_affectation SET statut='no' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function getLastAffectation(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_affectation ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }
    /* End Affectation */

    /* Start Settings */
    function setSettings($title,$footer,$email){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $date_heure = date('Y-m-d H:i:s');

        $mdp = md5($mdp);

        $sql_verif = "SELECT id FROM tj_settings";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $sql = "UPDATE tj_settings SET title='$title', footer='$footer', email='$email', modifier='$date_heure'";
            $result = mysqli_query($con,$sql);
            $res = '1';
        }else{
            $sql = "INSERT INTO tj_settings (title, footer, email, creer) VALUES ('$title', '$footer', '$email', '$date_heure')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }

    function getSettings(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_settings LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }
    /* End Settings */

    /* Start User App */
    function setUtilisateurApp($conducteur,$vehicule,$statut){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $date_heure = date('Y-m-d H:i:s');

        $mdp = md5($mdp);

        $sql_verif = "SELECT id FROM tj_user_app WHERE id_taxi='$vehicule'";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_user_app (id_taxi, id_conducteur, statut, creer) VALUES ('$vehicule', '$conducteur', '$statut', '$date_heure')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }

    function setUtilisateurAppMod($id,$id_conducteur,$id_taxi,$statut){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_user_app SET id_conducteur=$id_conducteur, id_taxi=$id_taxi, statut='$statut', modifier='$date_heure' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }

    function getUserApp(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_user_app";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getUserAppById($id_affectation){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_user_app WHERE id=$id_affectation";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getIdUserAppByLibelle($lib_annee){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT id FROM tj_user_app WHERE libelle='$lib_annee'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
        }
        
        mysqli_close($con);
        return $id;
    }

    function delUserApp($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_user_app WHERE id=$id";
        $result = mysqli_query($con,$sql);
        mysqli_close($con);
    }

    function enableUserApp($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_user_app SET statut='yes' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function disableUserApp($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_user_app SET statut='no' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function getLastUserApp(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_user_app ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }
    /* End User App */

    /* Start Suggestion */
    function setSuggestion($conducteur,$vehicule,$statut){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $date_heure = date('Y-m-d H:i:s');

        $mdp = md5($mdp);

        $sql_verif = "SELECT id FROM tj_suggestion WHERE id_taxi='$vehicule'";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_suggestion (id_taxi, id_conducteur, statut, creer) VALUES ('$vehicule', '$conducteur', '$statut', '$date_heure')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }

    function setSuggestionMod($id,$id_conducteur,$id_taxi,$statut){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_suggestion SET id_conducteur=$id_conducteur, id_taxi=$id_taxi, statut='$statut', modifier='$date_heure' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }

    function getSuggestion(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT s.id,s.message,s.creer,s.modifier,s.id_user_app
        FROM tj_suggestion s, tj_user_app u WHERE s.id_user_app=u.id";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getSuggestionById($id_affectation){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_suggestion WHERE id=$id_affectation";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getIdSuggestionByLibelle($lib_annee){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT id FROM tj_suggestion WHERE libelle='$lib_annee'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
        }
        
        mysqli_close($con);
        return $id;
    }

    function delSuggestion($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_suggestion WHERE id=$id";
        $result = mysqli_query($con,$sql);
        mysqli_close($con);
    }

    function enableSuggestion($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_suggestion SET statut='yes' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function disableSuggestion($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_suggestion SET statut='no' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function getLastSuggestion(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_suggestion ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }
    /* End Suggestion */

    /* Start Commentaire */
    function setCommentaire($conducteur,$vehicule,$statut){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $date_heure = date('Y-m-d H:i:s');

        $mdp = md5($mdp);

        $sql_verif = "SELECT id FROM tj_commentaire WHERE id_taxi='$vehicule'";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_commentaire (id_taxi, id_conducteur, statut, creer) VALUES ('$vehicule', '$conducteur', '$statut', '$date_heure')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }

    function setCommentaireMod($id,$id_conducteur,$id_taxi,$statut){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_commentaire SET id_conducteur=$id_conducteur, id_taxi=$id_taxi, statut='$statut', modifier='$date_heure' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }

    function getCommentaire(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT c.id,c.description,c.id_conducteur,c.creer,c.modifier,c.id_user_app,c.statut
        FROM tj_commentaire c, tj_user_app u WHERE c.id_user_app=u.id";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getCommentaireById($id_affectation){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_commentaire WHERE id=$id_affectation";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getIdCommentaireByLibelle($lib_annee){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT id FROM tj_commentaire WHERE libelle='$lib_annee'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
        }
        
        mysqli_close($con);
        return $id;
    }

    function delCommentaire($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_commentaire WHERE id=$id";
        $result = mysqli_query($con,$sql);
        mysqli_close($con);
    }

    function enableCommentaire($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_commentaire SET statut='yes' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function disableCommentaire($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_commentaire SET statut='no' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function getLastCommentaire(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_commentaire ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }
    /* End Commentaire */

    /* Start Requête */
    function setRequete($conducteur,$vehicule,$statut){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $date_heure = date('Y-m-d H:i:s');

        $mdp = md5($mdp);

        $sql_verif = "SELECT id FROM tj_requete WHERE id_taxi='$vehicule'";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_requete (id_taxi, id_conducteur, statut, creer) VALUES ('$vehicule', '$conducteur', '$statut', '$date_heure')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }

    function setRequeteMod($id,$id_conducteur,$id_taxi,$statut){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_requete SET id_conducteur=$id_conducteur, id_taxi=$id_taxi, statut='$statut', modifier='$date_heure' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }

    function getRequete(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT r.id,r.distance,r.creer,r.modifier,r.id_user_app,r.statut,r.depart_name,r.destination_name,r.duree,r.montant,r.trajet,u.nom,u.prenom
        ,c.nom as nomDriver,c.prenom as prenomDriver,r.statut_paiement,m.libelle as payment,m.image as payment_image
        FROM tj_requete r, tj_user_app u, tj_conducteur c, tj_payment_method m WHERE r.id_user_app=u.id AND r.id_payment_method=m.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getRequeteAmount(){
        include("connexion.php");
        $con->set_charset("utf8");

        $sql_cu = "SELECT montant as cu
        FROM tj_requete r, tj_user_app u, tj_conducteur c WHERE r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result_cu = mysqli_query($con,$sql_cu);
        $earning = 0;

        $sql_com = "SELECT value FROM tj_commission WHERE type='Percentage' AND statut='yes' ORDER BY id DESC LIMIT 1";
        $result_com = mysqli_query($con,$sql_com);
        if(mysqli_num_rows($result_com) > 0){
            $row_com = mysqli_fetch_assoc($result_com);
            $value = $row_com['value'];
            $value = (float)($value);

            // output data of each row
            $value_fixed = 0;
            $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com_fixed = mysqli_query($con,$sql_com_fixed);
            if(mysqli_num_rows($result_com_fixed) > 0){
                $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                $value_fixed = $row_com_fixed['value'];
            }

            while($row_cu = mysqli_fetch_assoc($result_cu)) {
                $cu = $row_cu['cu'];
                $cu = ($cu - $value_fixed) * $value;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }else{
            $sql_com = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com = mysqli_query($con,$sql_com);
            if(mysqli_num_rows($result_com) > 0){
                $row_com = mysqli_fetch_assoc($result_com);

                // output data of each row
                $value_fixed = 0;
                $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
                $result_com_fixed = mysqli_query($con,$sql_com_fixed);
                $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                if(mysqli_num_rows($result_com_fixed) > 0){
                    $value_fixed = $row_com_fixed['value'];
                }

                while($row_cu = mysqli_fetch_assoc($result_cu)) {
                    $cu = $row_cu['cu'];
                    $earning = (Float)$earning + (Float)$value_fixed;
                }
            }else{

            }
        }

        // $sql_com = "SELECT value FROM tj_commission ORDER BY id DESC LIMIT 1";
        // $result_com = mysqli_query($con,$sql_com);
        // $row_com = mysqli_fetch_assoc($result_com);
        // $value = $row_com['value'];
        // // output data of each row
        // while($row_cu = mysqli_fetch_assoc($result_cu)) {
        //     $cu = $row_cu['cu'];
        //     $cu = $cu * $value;
        //     $earning = $earning + $cu;
        // }

        $sql = "SELECT sum(r.montant) as montant
        FROM tj_requete r, tj_user_app u, tj_conducteur c WHERE r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $row['earning'] = $earning;
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getRequeteNew(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT r.id,r.distance,r.creer,r.modifier,r.id_user_app,r.statut,r.depart_name,r.destination_name,r.duree,r.montant,r.trajet,u.nom,u.prenom
        ,c.nom as nomDriver,c.prenom as prenomDriver,r.statut_paiement,m.libelle as payment,m.image as payment_image
        FROM tj_requete r, tj_user_app u, tj_conducteur c, tj_payment_method m WHERE r.statut='new' AND r.id_payment_method=m.id AND r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getRequeteNewAmount(){
        include("connexion.php");
        $con->set_charset("utf8");

        $sql_cu = "SELECT montant as cu
        FROM tj_requete r, tj_user_app u, tj_conducteur c WHERE r.statut='new' AND r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result_cu = mysqli_query($con,$sql_cu);
        $earning = 0;

        $sql_com = "SELECT value FROM tj_commission WHERE type='Percentage' AND statut='yes' ORDER BY id DESC LIMIT 1";
        $result_com = mysqli_query($con,$sql_com);
        if(mysqli_num_rows($result_com) > 0){
            $row_com = mysqli_fetch_assoc($result_com);
            $value = $row_com['value'];
            $value = (float)($value);

            // output data of each row
            $value_fixed = 0;
            $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com_fixed = mysqli_query($con,$sql_com_fixed);
            if(mysqli_num_rows($result_com_fixed) > 0){
                $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                $value_fixed = $row_com_fixed['value'];
            }

            while($row_cu = mysqli_fetch_assoc($result_cu)) {
                $cu = $row_cu['cu'];
                $cu = ($cu - $value_fixed) * $value;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }else{
            $sql_com = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com = mysqli_query($con,$sql_com);
            if(mysqli_num_rows($result_com) > 0){
                $row_com = mysqli_fetch_assoc($result_com);

                // output data of each row
                $value_fixed = 0;
                $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
                $result_com_fixed = mysqli_query($con,$sql_com_fixed);
                $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                if(mysqli_num_rows($result_com_fixed) > 0){
                    $value_fixed = $row_com_fixed['value'];
                }

                while($row_cu = mysqli_fetch_assoc($result_cu)) {
                    $cu = $row_cu['cu'];
                    $earning = (Float)$earning + (Float)$value_fixed;
                }
            }else{

            }
        }

        // $sql_com = "SELECT value FROM tj_commission ORDER BY id DESC LIMIT 1";
        // $result_com = mysqli_query($con,$sql_com);
        // $row_com = mysqli_fetch_assoc($result_com);
        // $value = $row_com['value'];
        // // output data of each row
        // while($row_cu = mysqli_fetch_assoc($result_cu)) {
        //     $cu = $row_cu['cu'];
        //     $cu = $cu * $value;
        //     $earning = $earning + $cu;
        // }

        $sql = "SELECT sum(r.montant) as montant
        FROM tj_requete r, tj_user_app u, tj_conducteur c WHERE r.statut='new' AND r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $row['earning'] = $earning;
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getRequeteConfirmedAmount(){
        include("connexion.php");
        $con->set_charset("utf8");

        $sql_cu = "SELECT montant as cu
        FROM tj_requete r, tj_user_app u, tj_conducteur c WHERE r.statut='confirmed' AND r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result_cu = mysqli_query($con,$sql_cu);
        $earning = 0;

        $sql_com = "SELECT value FROM tj_commission WHERE type='Percentage' AND statut='yes' ORDER BY id DESC LIMIT 1";
        $result_com = mysqli_query($con,$sql_com);
        if(mysqli_num_rows($result_com) > 0){
            $row_com = mysqli_fetch_assoc($result_com);
            $value = $row_com['value'];
            $value = (float)($value);

            // output data of each row
            $value_fixed = 0;
            $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com_fixed = mysqli_query($con,$sql_com_fixed);
            if(mysqli_num_rows($result_com_fixed) > 0){
                $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                $value_fixed = $row_com_fixed['value'];
            }

            while($row_cu = mysqli_fetch_assoc($result_cu)) {
                $cu = $row_cu['cu'];
                $cu = ($cu - $value_fixed) * $value;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }else{
            $sql_com = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com = mysqli_query($con,$sql_com);
            if(mysqli_num_rows($result_com) > 0){
                $row_com = mysqli_fetch_assoc($result_com);

                // output data of each row
                $value_fixed = 0;
                $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
                $result_com_fixed = mysqli_query($con,$sql_com_fixed);
                $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                if(mysqli_num_rows($result_com_fixed) > 0){
                    $value_fixed = $row_com_fixed['value'];
                }

                while($row_cu = mysqli_fetch_assoc($result_cu)) {
                    $cu = $row_cu['cu'];
                    $earning = (Float)$earning + (Float)$value_fixed;
                }
            }else{

            }
        }

        // $sql_com = "SELECT value FROM tj_commission ORDER BY id DESC LIMIT 1";
        // $result_com = mysqli_query($con,$sql_com);
        // $row_com = mysqli_fetch_assoc($result_com);
        // $value = $row_com['value'];
        // // output data of each row
        // while($row_cu = mysqli_fetch_assoc($result_cu)) {
        //     $cu = $row_cu['cu'];
        //     $cu = $cu * $value;
        //     $earning = $earning + $cu;
        // }

        $sql = "SELECT sum(r.montant) as montant
        FROM tj_requete r, tj_user_app u, tj_conducteur c WHERE r.statut='confirmed' AND r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $row['earning'] = $earning;
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getRequeteOnRideAmount(){
        include("connexion.php");
        $con->set_charset("utf8");

        $sql_cu = "SELECT montant as cu
        FROM tj_requete r, tj_user_app u, tj_conducteur c WHERE r.statut='on ride' AND r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result_cu = mysqli_query($con,$sql_cu);
        $earning = 0;

        $sql_com = "SELECT value FROM tj_commission WHERE type='Percentage' AND statut='yes' ORDER BY id DESC LIMIT 1";
        $result_com = mysqli_query($con,$sql_com);
        if(mysqli_num_rows($result_com) > 0){
            $row_com = mysqli_fetch_assoc($result_com);
            $value = $row_com['value'];
            $value = (float)($value);

            // output data of each row
            $value_fixed = 0;
            $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com_fixed = mysqli_query($con,$sql_com_fixed);
            if(mysqli_num_rows($result_com_fixed) > 0){
                $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                $value_fixed = $row_com_fixed['value'];
            }

            while($row_cu = mysqli_fetch_assoc($result_cu)) {
                $cu = $row_cu['cu'];
                $cu = ($cu - $value_fixed) * $value;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }else{
            $sql_com = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com = mysqli_query($con,$sql_com);
            if(mysqli_num_rows($result_com) > 0){
                $row_com = mysqli_fetch_assoc($result_com);

                // output data of each row
                $value_fixed = 0;
                $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
                $result_com_fixed = mysqli_query($con,$sql_com_fixed);
                $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                if(mysqli_num_rows($result_com_fixed) > 0){
                    $value_fixed = $row_com_fixed['value'];
                }

                while($row_cu = mysqli_fetch_assoc($result_cu)) {
                    $cu = $row_cu['cu'];
                    $earning = (Float)$earning + (Float)$value_fixed;
                }
            }else{

            }
        }

        // $sql_com = "SELECT value FROM tj_commission ORDER BY id DESC LIMIT 1";
        // $result_com = mysqli_query($con,$sql_com);
        // $row_com = mysqli_fetch_assoc($result_com);
        // $value = $row_com['value'];
        // // output data of each row
        // while($row_cu = mysqli_fetch_assoc($result_cu)) {
        //     $cu = $row_cu['cu'];
        //     $cu = $cu * $value;
        //     $earning = $earning + $cu;
        // }

        $sql = "SELECT sum(r.montant) as montant
        FROM tj_requete r, tj_user_app u, tj_conducteur c WHERE r.statut='on ride' AND r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $row['earning'] = $earning;
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getRequeteCompletedAmount(){
        include("connexion.php");
        $con->set_charset("utf8");

        $sql_cu = "SELECT montant as cu
        FROM tj_requete r, tj_user_app u, tj_conducteur c WHERE r.statut='completed' AND r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result_cu = mysqli_query($con,$sql_cu);
        $earning = 0;

        $sql_com = "SELECT value FROM tj_commission WHERE type='Percentage' AND statut='yes' ORDER BY id DESC LIMIT 1";
        $result_com = mysqli_query($con,$sql_com);
        if(mysqli_num_rows($result_com) > 0){
            $row_com = mysqli_fetch_assoc($result_com);
            $value = $row_com['value'];
            $value = (float)($value);

            // output data of each row
            $value_fixed = 0;
            $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com_fixed = mysqli_query($con,$sql_com_fixed);
            if(mysqli_num_rows($result_com_fixed) > 0){
                $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                $value_fixed = $row_com_fixed['value'];
            }

            while($row_cu = mysqli_fetch_assoc($result_cu)) {
                $cu = $row_cu['cu'];
                $cu = ($cu - $value_fixed) * $value;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }else{
            $sql_com = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com = mysqli_query($con,$sql_com);
            if(mysqli_num_rows($result_com) > 0){
                $row_com = mysqli_fetch_assoc($result_com);

                // output data of each row
                $value_fixed = 0;
                $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
                $result_com_fixed = mysqli_query($con,$sql_com_fixed);
                $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                if(mysqli_num_rows($result_com_fixed) > 0){
                    $value_fixed = $row_com_fixed['value'];
                }

                while($row_cu = mysqli_fetch_assoc($result_cu)) {
                    $cu = $row_cu['cu'];
                    $earning = (Float)$earning + (Float)$value_fixed;
                }
            }else{

            }
        }

        // $sql_com = "SELECT value FROM tj_commission ORDER BY id DESC LIMIT 1";
        // $result_com = mysqli_query($con,$sql_com);
        // $row_com = mysqli_fetch_assoc($result_com);
        // $value = $row_com['value'];
        // // output data of each row
        // while($row_cu = mysqli_fetch_assoc($result_cu)) {
        //     $cu = $row_cu['cu'];
        //     $cu = $cu * $value;
        //     $earning = $earning + $cu;
        // }
        
        $sql = "SELECT sum(r.montant) as montant, montant as cu
        FROM tj_requete r, tj_user_app u, tj_conducteur c WHERE r.statut='completed' AND r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $row['earning'] = $earning;
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getCustomerStats($id_customer,$month,$year){
        include("connexion.php");
        $con->set_charset("utf8");

        $time = strtotime($year.'-'.$month.'-01');
        $date1 = date('Y-m-01 00:00:00',$time);
        $date2 = date('Y-m-t 23:59:59',$time);

        $sql = "SELECT r.id,r.distance,r.creer,r.modifier,r.id_user_app,r.statut,r.depart_name,r.destination_name,r.duree,r.montant,r.trajet,u.nom,u.prenom
        ,c.nom as nomDriver,c.prenom as prenomDriver,r.statut_paiement,m.libelle as payment,m.image as payment_image,u.phone
        FROM tj_requete r, tj_user_app u, tj_conducteur c, tj_payment_method m WHERE r.statut='completed' AND r.id_payment_method=m.id AND r.id_user_app=u.id AND r.id_conducteur=c.id
        AND u.id=$id_customer AND r.creer>='$date1' AND r.creer<='$date2' ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getDriverStats($id_driver,$month,$year){
        include("connexion.php");
        $con->set_charset("utf8");

        $time = strtotime($year.'-'.$month.'-01');
        $date1 = date('Y-m-01 00:00:00',$time);
        $date2 = date('Y-m-t 23:59:59',$time);

        $sql = "SELECT r.id,r.distance,r.creer,r.modifier,r.id_user_app,r.statut,r.depart_name,r.destination_name,r.duree,r.montant,r.trajet,u.nom,u.prenom
        ,c.nom as nomDriver,c.prenom as prenomDriver,r.statut_paiement,m.libelle as payment,m.image as payment_image,u.phone
        FROM tj_requete r, tj_user_app u, tj_conducteur c, tj_payment_method m WHERE r.statut='completed' AND r.id_payment_method=m.id AND r.id_user_app=u.id AND r.id_conducteur=c.id
        AND c.id=$id_driver AND r.creer>='$date1' AND r.creer<='$date2' ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getEarningStats($month,$year){
        include("connexion.php");
        $con->set_charset("utf8");

        $time = strtotime($year.'-'.$month.'-01');
        $date1 = date('Y-m-01 00:00:00',$time);
        $date2 = date('Y-m-t 23:59:59',$time);

        $sql = "SELECT r.id,r.distance,r.creer,r.modifier,r.id_user_app,r.statut,r.depart_name,r.destination_name,r.duree,r.montant,r.trajet,u.nom,u.prenom
        ,c.nom as nomDriver,c.prenom as prenomDriver,r.statut_paiement,m.libelle as payment,m.image as payment_image,u.phone
        FROM tj_requete r, tj_user_app u, tj_conducteur c, tj_payment_method m WHERE r.statut='completed' AND r.id_payment_method=m.id AND r.id_user_app=u.id AND r.id_conducteur=c.id
        AND r.creer>='$date1' AND r.creer<='$date2' ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getEarningStatsDashboard($year){
        include("connexion.php");
        $con->set_charset("utf8");

        $time = strtotime($year.'-01-01');
        $date1 = date('Y-01-01 00:00:00',$time);
        $date2 = date('Y-12-t 23:59:59',$time);

        $sql = "SELECT r.id,r.distance,r.creer,r.modifier,r.id_user_app,r.statut,r.depart_name,r.destination_name,r.duree,r.montant,r.trajet,u.nom,u.prenom
        ,c.nom as nomDriver,c.prenom as prenomDriver,r.statut_paiement,m.libelle as payment,m.image as payment_image,u.phone
        FROM tj_requete r, tj_user_app u, tj_conducteur c, tj_payment_method m WHERE r.statut='completed' AND r.id_payment_method=m.id AND r.id_user_app=u.id AND r.id_conducteur=c.id
        AND r.creer>='$date1' AND r.creer<='$date2' ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getRequeteAllSaleTodayAmount(){
        include("connexion.php");
        $con->set_charset("utf8");
        $date_start = date('Y-m-d 00:00:00');
        $date_end = date('Y-m-d 23:59:59');
        
        $sql = "SELECT count(id) as nb_sales FROM tj_requete WHERE statut='completed' AND creer >= '$date_start' AND creer <= '$date_end'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getRequeteCanceledAmount(){
        include("connexion.php");
        $con->set_charset("utf8");

        $sql_cu = "SELECT montant as cu
        FROM tj_requete r, tj_user_app u, tj_conducteur c WHERE r.statut='canceled' AND r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result_cu = mysqli_query($con,$sql_cu);
        $earning = 0;

        $sql_com = "SELECT value FROM tj_commission WHERE type='Percentage' AND statut='yes' ORDER BY id DESC LIMIT 1";
        $result_com = mysqli_query($con,$sql_com);
        if(mysqli_num_rows($result_com) > 0){
            $row_com = mysqli_fetch_assoc($result_com);
            $value = $row_com['value'];
            $value = (float)($value);

            // output data of each row
            $value_fixed = 0;
            $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com_fixed = mysqli_query($con,$sql_com_fixed);
            if(mysqli_num_rows($result_com_fixed) > 0){
                $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                $value_fixed = $row_com_fixed['value'];
            }

            while($row_cu = mysqli_fetch_assoc($result_cu)) {
                $cu = $row_cu['cu'];
                $cu = ($cu - $value_fixed) * $value;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }else{
            $sql_com = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com = mysqli_query($con,$sql_com);
            if(mysqli_num_rows($result_com) > 0){
                $row_com = mysqli_fetch_assoc($result_com);

                // output data of each row
                $value_fixed = 0;
                $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
                $result_com_fixed = mysqli_query($con,$sql_com_fixed);
                $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                if(mysqli_num_rows($result_com_fixed) > 0){
                    $value_fixed = $row_com_fixed['value'];
                }

                while($row_cu = mysqli_fetch_assoc($result_cu)) {
                    $cu = $row_cu['cu'];
                    $earning = (Float)$earning + (Float)$value_fixed;
                }
            }else{

            }
        }

        // $sql_com = "SELECT value FROM tj_commission ORDER BY id DESC LIMIT 1";
        // $result_com = mysqli_query($con,$sql_com);
        // $row_com = mysqli_fetch_assoc($result_com);
        // $value = $row_com['value'];
        // // output data of each row
        // while($row_cu = mysqli_fetch_assoc($result_cu)) {
        //     $cu = $row_cu['cu'];
        //     $cu = $cu * $value;
        //     $earning = $earning + $cu;
        // }

        $sql = "SELECT sum(r.montant) as montant
        FROM tj_requete r, tj_user_app u, tj_conducteur c WHERE r.statut='canceled' AND r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $row['earning'] = $earning;
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getRequeteMonthEarnAmount(){
        include("connexion.php");
        $con->set_charset("utf8");
        $date_heure = date('Y-m-d');
        $date_start = date("Y-m-d", strtotime(date('Y-m-1')));
        $date_end = date("Y-m-t", strtotime($date_heure));

        $sql_cu = "SELECT montant as cu
        FROM tj_requete r, tj_user_app u, tj_conducteur c WHERE r.statut='completed' AND r.id_user_app=u.id AND r.id_conducteur=c.id AND r.creer >= '$date_start' AND r.creer <= '$date_end'
        ORDER BY r.id DESC";
        $result_cu = mysqli_query($con,$sql_cu);
        $earning = 0;

        $sql_com = "SELECT value FROM tj_commission WHERE type='Percentage' AND statut='yes' ORDER BY id DESC LIMIT 1";
        $result_com = mysqli_query($con,$sql_com);
        if(mysqli_num_rows($result_com) > 0){
            $row_com = mysqli_fetch_assoc($result_com);
            $value = $row_com['value'];
            $value = (float)($value);

            // output data of each row
            $value_fixed = 0;
            $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com_fixed = mysqli_query($con,$sql_com_fixed);
            if(mysqli_num_rows($result_com_fixed) > 0){
                $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                $value_fixed = $row_com_fixed['value'];
            }

            while($row_cu = mysqli_fetch_assoc($result_cu)) {
                $cu = $row_cu['cu'];
                $cu = ($cu - $value_fixed) * $value;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }else{
            $sql_com = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com = mysqli_query($con,$sql_com);
            if(mysqli_num_rows($result_com) > 0){
                $row_com = mysqli_fetch_assoc($result_com);

                // output data of each row
                $value_fixed = 0;
                $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
                $result_com_fixed = mysqli_query($con,$sql_com_fixed);
                $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                if(mysqli_num_rows($result_com_fixed) > 0){
                    $value_fixed = $row_com_fixed['value'];
                }

                while($row_cu = mysqli_fetch_assoc($result_cu)) {
                    $cu = $row_cu['cu'];
                    $earning = (Float)$earning + (Float)$value_fixed;
                }
            }else{

            }
        }

        $sql = "SELECT sum(r.montant) as montant
        FROM tj_requete r, tj_user_app u, tj_conducteur c WHERE r.statut='completed' AND r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $row['earning'] = $earning;
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getRequeteTodayEarnAmount(){
        include("connexion.php");
        $con->set_charset("utf8");
        $date_start = date('Y-m-d 00:00:00');
        $date_end = date('Y-m-d 23:59:59');
        // echo $date_start;
        // echo $date_end;

        $sql_cu = "SELECT montant as cu
        FROM tj_requete r, tj_user_app u, tj_conducteur c WHERE r.statut='completed' AND r.id_user_app=u.id AND r.id_conducteur=c.id AND r.creer >= '$date_start' AND r.creer <= '$date_end'
        ORDER BY r.id DESC";
        $result_cu = mysqli_query($con,$sql_cu);
        $earning = 0;

        $sql_com = "SELECT value FROM tj_commission WHERE type='Percentage' AND statut='yes' ORDER BY id DESC LIMIT 1";
        $result_com = mysqli_query($con,$sql_com);
        if(mysqli_num_rows($result_com) > 0){
            $row_com = mysqli_fetch_assoc($result_com);
            $value = $row_com['value'];
            $value = (float)($value);

            // output data of each row
            $value_fixed = 0;
            $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com_fixed = mysqli_query($con,$sql_com_fixed);
            if(mysqli_num_rows($result_com_fixed) > 0){
                $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                $value_fixed = $row_com_fixed['value'];
            }

            while($row_cu = mysqli_fetch_assoc($result_cu)) {
                $cu = $row_cu['cu'];
                $cu = ($cu - $value_fixed) * $value;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }else{
            $sql_com = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com = mysqli_query($con,$sql_com);
            if(mysqli_num_rows($result_com) > 0){
                $row_com = mysqli_fetch_assoc($result_com);

                // output data of each row
                $value_fixed = 0;
                $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
                $result_com_fixed = mysqli_query($con,$sql_com_fixed);
                $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                if(mysqli_num_rows($result_com_fixed) > 0){
                    $value_fixed = $row_com_fixed['value'];
                }

                while($row_cu = mysqli_fetch_assoc($result_cu)) {
                    $cu = $row_cu['cu'];
                    $earning = (Float)$earning + (Float)$value_fixed;
                }
            }else{

            }
        }

        $sql = "SELECT sum(r.montant) as montant
        FROM tj_requete r, tj_user_app u, tj_conducteur c WHERE r.statut='completed' AND r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $row['earning'] = $earning;
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getRequeteWeekEarnAmount(){
        include("connexion.php");
        $con->set_charset("utf8");
        $day = date('w');
        $week_start = date('Y-m-d', strtotime('-'.$day.' days'));
        $week_end = date('Y-m-d', strtotime('+'.(6-$day).' days'));
        $week_start = date('Y-m-d', strtotime($week_start . ' +1 day'));
        $week_end = date('Y-m-d', strtotime($week_end . ' +1 day'));
        
        // echo $week_start;
        // echo $week_end;

        $sql_cu = "SELECT montant as cu
        FROM tj_requete r, tj_user_app u, tj_conducteur c WHERE r.statut='completed' AND r.id_user_app=u.id AND r.id_conducteur=c.id AND r.creer >= '$week_start' AND r.creer <= '$week_end'
        ORDER BY r.id DESC";
        $result_cu = mysqli_query($con,$sql_cu);
        $earning = 0;

        $sql_com = "SELECT value FROM tj_commission WHERE type='Percentage' AND statut='yes' ORDER BY id DESC LIMIT 1";
        $result_com = mysqli_query($con,$sql_com);
        if(mysqli_num_rows($result_com) > 0){
            $row_com = mysqli_fetch_assoc($result_com);
            $value = $row_com['value'];
            $value = (float)($value);

            // output data of each row
            $value_fixed = 0;
            $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com_fixed = mysqli_query($con,$sql_com_fixed);
            if(mysqli_num_rows($result_com_fixed) > 0){
                $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                $value_fixed = $row_com_fixed['value'];
            }

            while($row_cu = mysqli_fetch_assoc($result_cu)) {
                $cu = $row_cu['cu'];
                $cu = ($cu - $value_fixed) * $value;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }
        }else{
            $sql_com = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com = mysqli_query($con,$sql_com);
            if(mysqli_num_rows($result_com) > 0){
                $row_com = mysqli_fetch_assoc($result_com);

                // output data of each row
                $value_fixed = 0;
                $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
                $result_com_fixed = mysqli_query($con,$sql_com_fixed);
                $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                if(mysqli_num_rows($result_com_fixed) > 0){
                    $value_fixed = $row_com_fixed['value'];
                }

                while($row_cu = mysqli_fetch_assoc($result_cu)) {
                    $cu = $row_cu['cu'];
                    $earning = (Float)$earning + (Float)$value_fixed;
                }
            }else{

            }
        }

        $sql = "SELECT sum(r.montant) as montant
        FROM tj_requete r, tj_user_app u, tj_conducteur c WHERE r.statut='completed' AND r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $row['earning'] = $earning;
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getRequeteConfirmed(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT r.id,r.distance,r.creer,r.modifier,r.id_user_app,r.statut,r.depart_name,r.destination_name,r.duree,r.montant,r.trajet,u.nom,u.prenom
        ,c.nom as nomDriver,c.prenom as prenomDriver,r.statut_paiement,m.libelle as payment,m.image as payment_image
        FROM tj_requete r, tj_user_app u, tj_conducteur c, tj_payment_method m WHERE r.statut='confirmed' AND r.id_payment_method=m.id AND r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getRequeteOnRide(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT r.id,r.distance,r.creer,r.modifier,r.id_user_app,r.statut,r.depart_name,r.destination_name,r.duree,r.montant,r.trajet,u.nom,u.prenom
        ,c.nom as nomDriver,c.prenom as prenomDriver,r.statut_paiement,m.libelle as payment,m.image as payment_image
        FROM tj_requete r, tj_user_app u, tj_conducteur c, tj_payment_method m WHERE r.statut='on ride' AND r.id_payment_method=m.id AND r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getRequeteCompleted(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT r.id,r.distance,r.creer,r.modifier,r.id_user_app,r.statut,r.depart_name,r.destination_name,r.duree,r.montant,r.trajet,u.nom,u.prenom
        ,c.nom as nomDriver,c.prenom as prenomDriver,r.statut_paiement,m.libelle as payment,m.image as payment_image
        FROM tj_requete r, tj_user_app u, tj_conducteur c, tj_payment_method m WHERE r.statut='completed' AND r.id_payment_method=m.id AND r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $cu = $row['montant'];
            $earning = 0;

            $sql_com = "SELECT value FROM tj_commission WHERE type='Percentage' AND statut='yes' ORDER BY id DESC LIMIT 1";
            $result_com = mysqli_query($con,$sql_com);
            if(mysqli_num_rows($result_com) > 0){
                $row_com = mysqli_fetch_assoc($result_com);
                $value = $row_com['value'];
                $value = (float)($value);
    
                // output data of each row
                $value_fixed = 0;
                $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
                $result_com_fixed = mysqli_query($con,$sql_com_fixed);
                if(mysqli_num_rows($result_com_fixed) > 0){
                    $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                    $value_fixed = $row_com_fixed['value'];
                }
    
                $cu = ($cu - $value_fixed) * $value;
                $earning = (Float)$earning + ((Float)$cu + (Float)$value_fixed);
            }else{
                $sql_com = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
                $result_com = mysqli_query($con,$sql_com);
                if(mysqli_num_rows($result_com) > 0){
                    $row_com = mysqli_fetch_assoc($result_com);
    
                    // output data of each row
                    $value_fixed = 0;
                    $sql_com_fixed = "SELECT value FROM tj_commission WHERE type='Fixed' AND statut='yes' ORDER BY id DESC LIMIT 1";
                    $result_com_fixed = mysqli_query($con,$sql_com_fixed);
                    $row_com_fixed = mysqli_fetch_assoc($result_com_fixed);
                    if(mysqli_num_rows($result_com_fixed) > 0){
                        $value_fixed = $row_com_fixed['value'];
                    }
    
                    $earning = (Float)$earning + (Float)$value_fixed;
                }else{
    
                }
            }

            // $sql_com = "SELECT value FROM tj_commission ORDER BY id DESC LIMIT 1";
            // $result_com = mysqli_query($con,$sql_com);
            // $row_com = mysqli_fetch_assoc($result_com);
            // $value = $row_com['value'];
            
            // $cu = $cu * $value;
            // $earning = $earning + $cu;
            $row['earning'] = $earning;

            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getRequeteCanceled(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT r.id,r.distance,r.creer,r.modifier,r.id_user_app,r.statut,r.depart_name,r.destination_name,r.duree,r.montant,r.trajet,u.nom,u.prenom
        ,c.nom as nomDriver,c.prenom as prenomDriver,r.statut_paiement,m.libelle as payment,m.image as payment_image
        FROM tj_requete r, tj_user_app u, tj_conducteur c, tj_payment_method m WHERE r.statut IN ('canceled','rejected') AND r.id_payment_method=m.id AND r.id_user_app=u.id AND r.id_conducteur=c.id
        ORDER BY r.id DESC";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getRequeteById($id_affectation){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_requete WHERE id=$id_affectation";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    function getIdRequeteByLibelle($lib_annee){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT id FROM tj_requete WHERE libelle='$lib_annee'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
        }
        
        mysqli_close($con);
        return $id;
    }

    function delRequete($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_requete WHERE id=$id";
        $result = mysqli_query($con,$sql);
        mysqli_close($con);
    }

    function enableRequete($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_requete SET statut='yes' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function disableRequete($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_requete SET statut='no' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function getLastRequete(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_requete ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }
    /* End Requête */

    /* Start Réservation */
    /*function setReservation($conducteur,$vehicule,$statut){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $date_heure = date('Y-m-d H:i:s');

        $mdp = md5($mdp);

        $sql_verif = "SELECT id FROM tj_reservation_taxi WHERE id_taxi='$vehicule'";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_reservation_taxi (id_taxi, id_conducteur, statut, creer) VALUES ('$vehicule', '$conducteur', '$statut', '$date_heure')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }*/

    /*function setReservationMod($id,$id_conducteur,$id_taxi,$statut){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_reservation_taxi SET id_conducteur=$id_conducteur, id_taxi=$id_taxi, statut='$statut', modifier='$date_heure' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }*/

    function getReservation(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT r.id,r.cout,r.distance,r.date_depart,r.heure_depart,r.contact,r.creer,r.modifier,r.id_user_app,r.statut,u.nom,u.prenom
        FROM tj_reservation_taxi r, tj_user_app u WHERE r.id_user_app=u.id";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    /*function getReservationById($id_reservation){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_reservation_taxi WHERE id=$id_reservation";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }*/

    function getIdReservationByLibelle($lib_annee){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT id FROM tj_reservation_taxi WHERE libelle='$lib_annee'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
        }
        
        mysqli_close($con);
        return $id;
    }

    function delReservation($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_reservation_taxi WHERE id=$id";
        $result = mysqli_query($con,$sql);
        mysqli_close($con);
    }

    function enableReservation($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_reservation_taxi SET statut='accepter' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function disableReservation($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_reservation_taxi SET statut='refuser' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function closeReservation($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_reservation_taxi SET statut='clôturer' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function getLastReservation(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_reservation_taxi ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }
    /* End Réservation */

    /* Start Location */
    /*function setLocation($conducteur,$vehicule,$statut){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $date_heure = date('Y-m-d H:i:s');

        $mdp = md5($mdp);

        $sql_verif = "SELECT id FROM tj_location_vehicule WHERE id_taxi='$vehicule'";
        $result_verif = mysqli_query($con,$sql_verif);

        if(mysqli_num_rows($result_verif) > 0){
            $res = '2';
        }else{
            $sql = "INSERT INTO tj_location_vehicule (id_taxi, id_conducteur, statut, creer) VALUES ('$vehicule', '$conducteur', '$statut', '$date_heure')";
            $result = mysqli_query($con,$sql);
            if($result == 1){
                $res = '1';
            } else {
                $res = '0';
            }
        }
        mysqli_close($con);
        return $res;
    }*/

    /*function setLocationMod($id,$id_conducteur,$id_taxi,$statut){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $date_heure = date('Y-m-d H:i:s');

        $sql = "UPDATE tj_location_vehicule SET id_conducteur=$id_conducteur, id_taxi=$id_taxi, statut='$statut', modifier='$date_heure' WHERE id=$id";
        $result = mysqli_query($con,$sql);
        
        mysqli_close($con);
        return $res;
    }*/

    function getLocation(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT l.id,l.nb_jour,l.contact,l.date_debut,l.date_fin,l.creer,l.modifier,l.id_user_app,l.statut,
        u.nom,u.prenom,tv.libelle as libTypeVehicule
        FROM tj_location_vehicule l, tj_user_app u, tj_vehicule_rental v, tj_type_vehicule_rental tv
        WHERE l.id_user_app=u.id AND l.id_vehicule_rental=v.id AND v.id_type_vehicule_rental=tv.id";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }

    /*function getLocationById($id_reservation){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_location_vehicule WHERE id=$id_reservation";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }*/

    function getIdLocationByLibelle($lib_annee){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT id FROM tj_location_vehicule WHERE libelle='$lib_annee'";
        $result = mysqli_query($con,$sql);
        // output data of each row
        $id = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
        }
        
        mysqli_close($con);
        return $id;
    }

    function delLocation($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "DELETE FROM tj_location_vehicule WHERE id=$id";
        $result = mysqli_query($con,$sql);
        mysqli_close($con);
    }

    function enableLocation($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_location_vehicule SET statut='accepted' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function disableLocation($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_location_vehicule SET statut='refuse' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function closeLocation($id){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "UPDATE tj_location_vehicule SET statut='fenced' WHERE id=$id";
        $result = mysqli_query($con,$sql);
    }

    function getLastLocation(){
        include("connexion.php");
        $con->set_charset("utf8");
        $sql = "SELECT * FROM tj_location_vehicule ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($con,$sql);
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $output[] = $row;
        }
        
        mysqli_close($con);
        if(mysqli_num_rows($result) > 0){
            return $output;
        }else{
            return $output = [];
        }
    }
    /* End Location */

    /* Start change mot de passe */
    function setChangeMdp($anc_mdp,$new_mdp){
        include("connexion.php");
        $con->set_charset("utf8");
        $res = '0';
        $anc_mdp = str_replace("'","\'",$anc_mdp);
        $new_mdp = str_replace("'","\'",$new_mdp);
        $date_heure = date('Y-m-d H:i:s');

        $anc_mdp = md5($anc_mdp);
        $new_mdp = md5($new_mdp);

        $sql = "SELECT id FROM tj_user WHERE mdp='$anc_mdp'";
        $result = mysqli_query($con,$sql);
        if(mysqli_num_rows($result) > 0){
            $sql1 = "UPDATE tj_user SET mdp='$new_mdp' WHERE mdp='$anc_mdp'";
            if (mysqli_query($con,$sql1)) {
                $res = '1';
            } else {
                $res = '0';
            }
        }else{
            $res = '0';
        }
        
        return $res;
    }
    /* End change mot de passe */

    /* Start Resize image */
    function resizeImage($img,$width,$height,$name){
        /*	Purpose: Open image
        *	Usage:	 resize('filename.type')
        * 	Params:	 filename.type - the filename to open
        */
        $magicianObj = new imageLib($img);


        /*	Purpose: Resize image
        *	Usage:	 resizeImage([width], [height])
        * 	Params:	 width - the new width to resize to
        *			 height - the new height to resize to 
        */	
        // $magicianObj -> resizeImage($width, $height);
        $magicianObj -> resizeImage($width, $height, 'crop', true);


        /*	Purpose: Save image
        *	Usage:	 saveImage('[filename.type]', [quality])
        * 	Params:	 filename.type - the filename and file type to save as
        * 			 quality - (optional) 0-100 (100 being the highest (default))
        *				Only applies to jpg & png only
        */
        $magicianObj -> saveImage($name, 100);
    }
    /* End Resize image */
?>