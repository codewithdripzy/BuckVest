<?php
    class Payment{
        private $base_url = "https://blockchain.info/merchant/";

        function deposit($wallet_address, $amount, $password, $auth_key, $to, $from, $fee){
            $this->base_url .= "{$wallet_address}/payment?password={$password}&second_password={$auth_key}&to={$to}&amount={$amount}&from={$from}&fee={$fee}";
            print($this->base_url);
            
            $req = curl_init($this->base_url);

            curl_setopt($req, CURLOPT_URL, $this->base_url);
            curl_setopt($req, CURLOPT_RETURNTRANSFER, 1);

            $res = curl_exec($req);

            print_r($res);
            
        }
    }

?>