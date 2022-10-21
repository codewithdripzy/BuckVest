<?php
    if($_REQUEST){
        include_once '../config/database.php';
        include_once '../models/user.php';
        include_once '../models/earnings.php';
        include_once '../models/wallet.php';
        include_once '../models/transaction.php';
        include_once '../models/referrals.php';
        include_once '../models/investment.php';
        include_once './payment.php';


        if(isset($_REQUEST['request_type']) && !empty($_REQUEST['request_type'])){
            $database = new Database();
            $db = $database->getConnection();

            $transaction = new Transction($db);
            $wallet = new Wallet($db);
            $refferals = new Referral($db);
            $user = new User($db);
            $earning = new Earnings($db);
            $investment = new Investment($db);
            $payment = new Payment();

            if($_REQUEST['request_type'] == 'delete_user'){
                if(isset($_REQUEST['email']) && !empty($_REQUEST['email'])){
                    if($user->deleteAccount($_REQUEST['email'])){
                        $flags['state'] = true;
                        $flags['msg'] = 'success';
                    }else{
                        $flags['state'] = true;
                        $flags['msg'] = 'Success';
                    }
                }else{
                    $flags['state'] = false;
                    $flags['msg'] = 'Something went wrong! Invalid Request';
                } 

                print_r(json_encode($flags));
                return $flags;
            }
            else if($_REQUEST['request_type'] == 'verify_user'){
                if(isset($_REQUEST['email']) && !empty($_REQUEST['email'])){
                    if($user->verifyAccount($_REQUEST['email'])){
                        $flags['state'] = true;
                        $flags['msg'] = 'success';
                    }else{
                        $flags['state'] = false;
                        $flags['msg'] = 'Something went wrong! it is not your fault.';
                    }
                }else{
                    $flags['state'] = false;
                    $flags['msg'] = 'Something went wrong! Invalid Request';
                } 

                print_r(json_encode($flags));
                return $flags;
            }
            else if($_REQUEST['request_type'] == 'verify_transaction'){
                if(isset($_REQUEST['transaction_type']) && !empty($_REQUEST['transaction_type'])){
                    if(isset($_REQUEST['token']) && !empty($_REQUEST['token'])){
                        if($transaction->verifyTransaction($_REQUEST['token'], $_REQUEST['wallet_address'], $_REQUEST['transaction_type'])){
                            $flags['state'] = true;
                            $flags['msg'] = 'success';
                        }else{
                            $flags['state'] = false;
                            $flags['msg'] = 'Something went wrong! it is not your fault.';
                        }
                    }else{
                        $flags['state'] = false;
                        $flags['msg'] = 'Something went wrong! Invalid Request';
                    } 
                }else{
                    $flags['state'] = false;
                    $flags['msg'] = 'Something went wrong! Invalid Request';
                }

                print_r(json_encode($flags));
                return $flags;
            }
            else if($_REQUEST['request_type'] == 'delete_transaction'){
                $transaction->getTransactionByType($_REQUEST['wallet_address'], $_REQUEST['token'], $_REQUEST['transaction_type']);
                if(isset($_REQUEST['transaction_type']) && !empty($_REQUEST['transaction_type'])){
                    if(isset($_REQUEST['token']) && !empty($_REQUEST['token'])){
                        
                        if($wallet->deductAmount($transaction->to_wallet_address, $transaction->amount)){
                            if($transaction->deleteTransaction($_REQUEST['token'], $_REQUEST['wallet_address'], $_REQUEST['transaction_type'])){
                                $flags['state'] = true;
                                $flags['msg'] = 'success';
                            }else{
                                $flags['state'] = false;
                                $flags['msg'] = 'Something went wrong! it is not your fault.';
                            }
                        }else{
                            $flags['msg'] = $transaction->to_wallet_address;
                            $flags['state'] = false;
                            $flags['msg'] = 'Something went wrong while deleting this record!';
                        }
                    }else{
                        $flags['state'] = false;
                        $flags['msg'] = 'Something went wrong! Invalid Request';
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