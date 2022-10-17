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

        $res = array();

        if(isset($_REQUEST['request_type']) && !empty($_REQUEST['request_type']) && $_REQUEST['request_type'] == 'wallet_balance'){
            $wallet->getWalletByUser($_REQUEST['user_id']);
            
            $res['user_id'] = $wallet->user_id;
            $res['public_wallet_address'] = $wallet->public_wallet_address;
            $res['balance'] = $wallet->balance;
            $res['wallet_type'] = $wallet->wallet_type;
            $res['walet_key'] = $wallet->wallet_key;
            $res['access_code'] = $wallet->access_code;
            $res['status'] = $wallet->status;
            $res['created'] = $wallet->created;
            $res['state'] = true;
            $res['msg'] = 'success';


            print_r(json_encode($res));
            return $res;
        }
        else if($_REQUEST['request_type'] == 'referral_bonus'){
            $res = array();
            $flags = array();
            $group = array();
            $response = array();

            $stmt = $refferals->readRefferals($_REQUEST['user_id']);
            $count = $stmt->rowCount();
            
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $res['referral_id'] = $row['referral_id'];
                $res['referred_id'] = $row['referral_id'];
                $res['token'] = $row['token'];
                $res['bonus'] = $row['bonus'];
                $res['created'] = $row['created'];

                
                $group[] = $res;
            }
            $flag['msg'] = 'success';
            $flag['state'] = true;

            $response[0] = $group;
            $response[1] = $flag;

            print_r(json_encode($response));
            return $res;
        }
        else if($_REQUEST['request_type'] == 'earnings'){
            $res = array();
            $flags = array();
            $group = array();

            $wallet->getWalletByUser($_REQUEST['user_id']);

            if(isset($wallet->public_wallet_address) && !empty($wallet->public_wallet_address)){
                $stmt = $earning->readEarnings($wallet->public_wallet_address);
                
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $group[] = $row;
                }
            }
            
            $flag['state'] = true;
            $flag['msg'] = 'success';

            $res[0] = $group;
            $res[1] = $flag;

            print_r(json_encode($res));
            return $res;
        }
        else if($_REQUEST['request_type'] == 'my_referrals'){
            $res = array();
            $response = array();
            $flags = array();
            $data = array();

            $stmt = $refferals->readRefferals($_REQUEST['user_id']);

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $user->readOne($row['referred_id']);

                $data['fullname'] = $user->fullname;
                $data['email'] = $user->email;
                $data['status'] = $user->status;
                $data['created'] = $user->created;

                $response[] = $data;
            }

            $flags['state'] = true;
            $flags['msg'] = 'success';

            $res[0] = $response;
            $res[1] = $flags;

            print_r(json_encode($res));
        }
        // else if($_REQUEST['request_type'] == ''){

        // }

    }
?>