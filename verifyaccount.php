<?php
    if($_REQUEST){
        if(isset($_REQUEST["access_code"]) && !empty($_REQUEST["access_code"])){
            if(isset($_SESSION["access_code"]) && !empty($_SESSION["access_code"]) && isset($_SESSION["expire"]) && !empty($_SESSION["expire"] && isset($_SESSION["email"]) && !empty($_SESSION["email"]))){
                if(($_SESSION["expire"] - time()) < 1800){
                    if($_SESSION["access_code"] == $_REQUEST["access_code"]){
                        include_once "config/database.php";
                        include_once "models/user.php";

                        $database = new Database();
                        $db = $database->getConnection();
                        $user = new User($db);
                        if($user->verifyAccount($_REQUEST["email"], $_SESSION["user_id"])){
                            ?>
                                <script>
                                    let link = document.createElement("a");
                                    link.hidden = true;
                                    link.href = "login";

                                    document.body.appendChild(link);
                                    link.click();
                                </script>
                            <?php
                        }else{
                            echo "Something Went wrong. Try Again...";
                        }
                    }else{
                        echo "Invalid Request...";
                    }
                }else{
                    echo "Invalid Request...";
                }
            }else{
                echo "Invalid Request...";
            }
        }else{
            echo "Invalid Request...";
        }
    }else{
        echo "Invalid Request...";
    }
?>