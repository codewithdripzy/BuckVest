<?php
    if($_REQUEST){
        include_once '../config/database.php';
        include_once '../models/user.php';
        include_once '../models/earnings.php';
        include_once '../models/wallet.php';
        include_once '../models/transaction.php';
        include_once '../models/referrals.php';
        include_once '../models/investment.php';
        include_once '../hash_generator.php';


        if(isset($_REQUEST['request_type']) && !empty($_REQUEST['request_type'])){
            $database = new Database();
            $db = $database->getConnection();

            $transaction = new Transction($db);
            $wallet = new Wallet($db);
            $refferals = new Referral($db);
            $user = new User($db);
            $earning = new Earnings($db);
            $investment = new Investment($db);
            // $payment = new Payment();

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
            else if($_REQUEST['request_type'] == 'deposit'){
                $transaction->from_wallet_address = $_REQUEST['from_wallet_address'];
                $transaction->to_wallet_address = $_REQUEST['to_wallet_address'];
                $transaction->previous_hash = $transaction->getPreviousHash();

                $user->readOne($_REQUEST['user_id']);

                $transaction->current_hash = HashGen::GenerateHash(array($user->fullname, rand(0,1000), $user->email, $user->created, $user->id, rand(0, 1000)));
                $transaction->amount = $_REQUEST['amount'];
                $transaction->description = 'Deposit to wallet';
                $transaction->token = md5(date("d-m-y H:I:s") . rand(0, 1000));

                $transaction->transaction_type = 'deposit';
                $transaction->status = 0;

                if(isset($_REQUEST['to_wallet_address']) && !empty($_REQUEST['to_wallet_address'])){
                    if($transaction->createBlock()){
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
        }
    }
?>