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

            if($_REQUEST['request_type'] == 'users'){
                $res = array();
                $group = array();
                $flags = array();

                $stmt = $user->readAll();
                
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $group[] = $row;
                }

                $flags['state'] = true;
                $flags['msg'] = 'success';

                $res[0] = $group;
                $res[1] = $flags;

                print_r(json_encode($res));

                return $res;
            }
            else if($_REQUEST['request_type'] == 'investments'){
                $res = array();
                $group = array();
                $flags = array();

                $stmt = $investment->readAll();
                
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $group[] = $row;
                }

                $flags['state'] = true;
                $flags['msg'] = 'success';

                $res[0] = $group;
                $res[1] = $flags;

                print_r(json_encode($res));

                return $res;
            }

            else if($_REQUEST['request_type'] == 'refferals'){
                $res = array();
                $group = array();
                $flags = array();
                $rel = array();

                $stmt = $refferals->readAll();
                
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $user->readOne($row['referred_id']);

                    $rel['fullname'] = $user->fullname;
                    $rel['email'] = $user->email;
                    $rel['status'] = $user->status;
                    $rel['created'] = $user->created;

                    $user->readOne($row['referral_id']);

                    $rel['referrer_name'] = $user->fullname;
                    $rel['referrer_email'] = $user->email;

                    $group[] = $rel;
                }

                $flags['state'] = true;
                $flags['msg'] = 'success';

                $res[0] = $group;
                $res[1] = $flags;

                print_r(json_encode($res));

                return $res;
            }

            else if($_REQUEST['request_type'] == 'deposit'){
                $res = array();
                $group = array();
                $flags = array();
                $res = array();

                $stmt = $transaction->readTransactionBlocksByType('deposit');
                
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $rel['payment_method'] = $row['from_wallet_address'];
                    $rel['wallet_address'] = $row['to_wallet_address'];
                    $rel['amount'] = $row['amount'];
                    $rel['reference_number'] = $row['token'];
                    $rel['status'] = $row['status'];
                    $rel['created'] = $row['created'];

                    $user_id = $wallet->getUserIdByAddress($row['to_wallet_address']);
                    $user->readOne($user_id);

                    $rel['fullname'] = $user->fullname;
                    $rel['email'] = $user->email;

                    $group[] = $rel;
                }

                $flags['state'] = true;
                $flags['msg'] = 'success';

                $res[0] = $group;
                $res[1] = $flags;

                print_r(json_encode($res));

                return $res;
            }

            else if($_REQUEST['request_type'] == 'transactions'){
                $res = array();
                $group = array();
                $flags = array();
    
                $stmt = $transaction->readOtherTransactionBlocksByType();
                
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $group[] = $row;
                }
    
                $flags['state'] = true;
                $flags['msg'] = 'success';
    
                $res[0] = $group;
                $res[1] = $flags;
    
                print_r(json_encode($res));
    
                return $res;
            }

            else if($_REQUEST['request_type'] == 'dashboard_data'){
                $res = array();
                $user_count = $user->readAllUsers()->rowCount();
                $referral_count = $refferals->readAll()->rowCount();
                // $transaction_count = $transaction->read()->rowCount();
                $withdrawals = $transaction->calculateWithdrawals();
                $wallet_gross = $wallet->calculateWalletGross();
                $cashflow = $transaction->calculateCashflow();

                $stmt = $transaction->readOtherTransactionBlocksByType();
                
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $group['users'] = $user_count;
                    $group['referral'] = $referral_count;
                    $group['withdrawals'] = $withdrawals;
                    $group['transactions'] = $user_count;
                    $group['cashflow'] = $cashflow;
                    $group['wallet_gross'] = $wallet_gross;
                }
    
                $flags['state'] = true;
                $flags['msg'] = 'success';
    
                $res[0] = $group;
                $res[1] = $flags;
    
                print_r(json_encode($res));
    
                return $res;
            }
        }
    }
?>