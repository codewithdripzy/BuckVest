<?php
    if ($_REQUEST) {
        include_once "../config/database.php";
        include_once "../models/user.php";

        if (isset($_REQUEST['email']) && !empty($_REQUEST['email'])) {
            $database = new Database();
            $db = $database->getConnection();

            $user = new User($db);

            if ($user->emailExist($_REQUEST['email'])) {
                $res = array();

                $res["message"] = "This email is associated with another account! Try another email";
                $res["err"] = 404;
                $res["state"] = false;
                $response = json_encode($res);

                echo $response;
                return $response;

            } else {
                $res = array();

                $res["message"] = "Email is valid";
                $res["err"] = null;
                $res["state"] = true;

                $response = json_encode($res);

                echo $response;
                return $response;
            }
        }
    } else {
        echo "Invalid Request!";
    }
?>