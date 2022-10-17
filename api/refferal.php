<?php
    if($_REQUEST){
        include_once "./config/database.php";
        include_once "./models/refferals.php";

        if(isset($_REQUEST["referral"]) && !empty($_REQUEST["referral"])){

            $database = new Database();
            $db = $database->getConnection();

            $referral = new Referral($db);

            $referral->referral_id = $_REQUEST["user_id"];
            $referral->referred_id = $_REQUEST["created_account_id"];
            
            header("../login");
        }
    }
?>