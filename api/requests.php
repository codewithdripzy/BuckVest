<?php
    if($_REQUEST){
        include_once '../config/database.php';
        include_once '../models/user.php';
        include_once '../models/earnings.php';
        include_once '../models/wallet.php';
        include_once '../models/transaction.php';
        include_once '../models/referrals.php';
        include_once '../models/investment.php';

        if(isset($_REQUEST['request_type']) && !empty($_REQUEST['request_type'])){
            $database = new Database();
            $db = $database->getConnection();

            $transaction = new Transction($db);
            $wallet = new Wallet($db);
            $refferals = new Referral($db);
            $user = new User($db);
            $earning = new Earnings($db);
            $investment = new Investment($db);

            if($_REQUEST['request_type'] == 'delete_user'){
                if(isset($_REQUEST['email']) && !empty($_REQUEST['email'])){
                    if($user->deleteAccount($_REQUEST['email'])){
                        $flags['state'] = true;
                        $flags['msg'] = 'success';
                    }else{
                        $flags['state'] = true;
                        $flags['msg'] = 'Something went wrong! it is not your fault.';
                    }
                }else{
                    $flags['state'] = false;
                    $flags['msg'] = 'Something went wrong! Invalid Request';
                } 

                print_r(json_encode($flags));
                return $flags;
            }
            else if($_REQUEST['request_type'] == 'delete_user'){
                if(isset($_REQUEST['email']) && !empty($_REQUEST['email'])){
                    if($user->deleteAccount($_REQUEST['email'])){
                        $flags['state'] = true;
                        $flags['msg'] = 'success';
                    }else{
                        $flags['state'] = true;
                        $flags['msg'] = 'Something went wrong! it is not your fault.';
                    }
                }else{
                    $flags['state'] = false;
                    $flags['msg'] = 'Something went wrong! Invalid Request';
                } 

                print_r(json_encode($flags));
                return $flags;
            }
        }
    }
?>