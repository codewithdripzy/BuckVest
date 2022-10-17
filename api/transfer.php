<?php
    if($_REQUEST){
        include_once '../config/database.php';
        include_once '../models/transaction.php';
        include_once '../models/wallet.php';
        include_once '../models/user.php';
        include_once '../models/referrals.php';
        include_once '../models/earnings.php';


        $database = new Database();
        $db = $database->getConnection();

        $transaction = new Transction($db);
        $wallet = new Wallet($db);
        $refferals = new Referral($db);
        $user = new User($db);
        $earning = new Earnings($db);

        if(isset($_REQUEST['wallet_address']) && !empty($_REQUEST['wallet_address']) && isset($_REQUEST['my_wallet_address']) && !empty($_REQUEST['my_wallet_address']) && isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])){
            if(isset($_REQUEST['amount']) & !empty($_REQUEST['amount'])){
                if($wallet->walletExists($_REQUEST['wallet_address'])){
                
                    $transaction->from_wallet_address = $_REQUEST['my_wallet_address'];
                    $transaction->to_wallet_address = $_REQUEST['wallet_address'];

                    $transaction->previous_hash = $transaction->getPreviousHash();
                    $user->emailExist($_REQUEST['user_id']);

                    $transaction->current_hash = hash('sha256', $_REQUEST['my_wallet_address'] . $user->fullname . $user->email . $user->created . $user->status . $_REQUEST['wallet_address']);
                    $transaction->amount = floatval($_REQUEST['amount']);
                    $transaction->description = 'Transfer';
                    $transaction->token = $user->fullname . sha1(rand(0, 1000));
                    $transaction->transaction_type = 'Transfer';
                    $transaction->status = 1;

                    if($wallet->compareBalance($_REQUEST['amount'], $_REQUEST['my_wallet_address'])){
                        if($transaction->createBlock()){
                            $user_id = $wallet->getUserIdByAddress($_REQUEST['wallet_address']);
                            
                            if($refferals->isRefferal($user_id)){
                                $earning->wallet_address = $_REQUEST['wallet_address'];
                                $earning->amount = 0.5;
                                $earning->token = sha1(rand(0, 10000));
            
                                $earning->earn(intval($_REQUEST['user_id']));
                            }

                            if($wallet->deductAmount($_REQUEST['my_wallet_address'], $_REQUEST['amount']) && $wallet->addAmount($_REQUEST['wallet_address'], $_REQUEST['amount'])){
                                $res['flag'] = true;
                                $res['msg'] = 'Transaction Sucessfull.';

                            print_r(json_encode($res));

                            }
                        }else{
                            $res['flag'] = false;
                            $res['msg'] = 'Something went wrong! it is not your fault, try Again.';

                            print_r(json_encode($res));
                        }
                    }else{
                        $res['flag'] = false;
                        $res['msg'] = 'Your wallet balance is too low to transfer this amount!';

                        print_r(json_encode($res));
                    }
                }else{
                    $res['flag'] = false;
                        $res['msg'] = 'The user with this wallet address does not exists!';

                        print_r(json_encode($res));
                }
            }
        }else{
            $res['flag'] = false;
            $res['msg'] = 'Something went wrong! it is not your fault, try Again.';

            print_r(json_encode($res));
        }
    }
?>