<?php
    if ($_REQUEST) {
        include_once '../config/database.php';
        include_once '../models/user.php';
        include_once '../models/referrals.php';
        include_once '../models/wallet.php';
        include_once './sendMail.php';



        $database = new Database();
        $db = $database->getConnection();

        $user = new User($db);
        $referral = new Referral($db);
        $wallet = new Wallet($db);
        $emailer = new Emailer();

        $user->fullname = $_REQUEST['fullname'];
        $user->email = $_REQUEST['email'];
        $user->password = $_REQUEST['password'];
        $user->access_level = 'user';
        $user->access_code = '';
        $user->status = 0;
        
        if (isset($_REQUEST['fullname']) && !empty($_REQUEST['fullname']) && isset($_REQUEST['email']) && !empty($_REQUEST['email']) && isset($_REQUEST['password']) && !empty($_REQUEST['password'])) {
            if($user->emailExist($_REQUEST['email'])){
                $res = array();

                $res['message'] = "This Email has been registered!";
                $res['err'] = 301;
                $res['state'] = false;

                $response = json_encode($res);

                echo $response;
                return $response;
            }else{
                $res = array();
                $access_code = sha1(md5(date('d-m-y H:I:s'). rand(1, 1000000)));
                session_start();

                $emailer->email = $_REQUEST['email'];
                $_SESSION['access_code'] = $access_code;
                $_SESSION['expire'] = time();

                if($emailer->sendAccountVerificationMail($access_code, $_REQUEST['fullname'])){
                    if ($user->createAccount()) {
                        $user->emailExist($_REQUEST['email']);
    
                        $_SESSION['user_id'] = $user->id;
                        $_SESSION['email'] = $_REQUEST['email'];

                        $wallet->user_id = $user->id;
                        $wallet->public_wallet_address = hash("sha256", $user->fullname . $user->email . $user->created . $user->status);
                        $wallet->private_wallet_address = hash("sha256", $user->status . $user->email . $user->fullname . $user->created);
                        $wallet->balance = 0;
                        $wallet->wallet_type = 1;
                        $wallet->wallet_key = null;
                        $wallet->access_code = md5("bucks" . rand(0, 1000) . $user->email . date("d-m-y H:I:s"));
                        $wallet->status = 1;
    
                        if($wallet->createWallet()){
                            //  do nothing
                        }else{
                            $user->deleteAccount($_REQUEST['email']);
                            $res['message'] = "Something went wrong! That's all we know.";
                            $res['err'] = 404;
                            $res['state'] = false;
                        }
                        
                        if(isset($_REQUEST['referral']) && !empty($_REQUEST['referral'])){
                            if($user->emailExist($_REQUEST['referral'])){
                            
                                $referral->referral_id = $user->id;
    
                                $user->emailExist($_REQUEST['email']);
        
                                $referral->referred_id = $user->id;
        
                                $referral->token = sha1(rand(100, 1000));
    
                                if($referral->referUser()){
                                    $res['referrals_msg'] = "Referral Created!";
                                }else{
                                    $res['referrals_msg'] = "Something went wrong thats all we know!";
                                }
                            }else{
                                $res['referrals_msg'] = "Unable to refer user, invalid referral link!";
                            }
                        }
                    
                        $_REQUEST = array();
                        
                        $res['message'] = "Account has been sucessfully created!";
                        $res['err'] = null;
                        $res['state'] = true;
    
                    } else {
                        $res['message'] = "Something went wrong! That's all we know.";
                        $res['err'] = 404;
                        $res['state'] = false;
                    }
    
                } else {
                    $res['message'] = "Something went wrong! That's all we know.";
                    $res['err'] = 404;
                    $res['state'] = false;
                }
                
                $response = json_encode($res);

                echo $response;
                return $response;
            }
        } else {
            echo "Invalid Request!";
        }
    }
?>