<?php
    if ($_REQUEST) {
        include_once "../config/database.php";
        include_once "../models/user.php";

        if (isset($_REQUEST['email']) && !empty($_REQUEST['email']) && isset($_REQUEST['password']) && !empty($_REQUEST['password'])) {
            $database = new Database();
            $db = $database->getConnection();

            $user = new User($db);

            if ($user->emailExist($_REQUEST['email'])) {
                if (password_verify($_REQUEST['password'], $user->password)) {
                    $res = array();

                    $res["id"] = $user->id;
                    $res["fullname"] = $user->fullname;
                    $res["email"] = $user->email;
                    $res["password"] = $user->password;
                    $res["status"] = $user->status;
                    $res["access_level"] = $user->access_level;
                    $res["access_code"] = $user->access_code;
                    $res["created"] = $user->created;
                    $res["modified"] = $user->modified;
                    $res["state"] = true;
                    $response = json_encode($res);

                    echo $response;
                    return $response;
                } else {
                    $res = array();

                    $res["message"] = "Incorrect Password!";
                    $res['err'] = 404;
                    $res["state"] = false;

                    $response = json_encode($res);

                    echo $response;
                    return $response;
                }
            } else {
                $res = array();

                $res["message"] = "Account does not exist!";
                $res["state"] = false;

                $response = json_encode($res);

                echo $response;
                return $response;
            }
        }
    } else {
        echo "Invalid Request!";
    }
