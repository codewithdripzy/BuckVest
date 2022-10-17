<?php
    class Wallet{
        public $id;
        public $user_id;
        public $public_wallet_address;
        public $private_wallet_address;
        public $balance;
        public $wallet_type;
        public $wallet_key;
        public $access_code;
        public $status;
        public $created;
        public $modified;

        private $table_name = "wallet";
        private $conn;

        function __construct($db)
        {
            $this->conn = $db;
        }

        private function showError($e){
            echo "<pre>";
                print_r($e);
            echo "</pre>";
        }

        function createWallet(){
            $this->created = date("y-m-d H:i:s");
            
            $query = "INSERT INTO " . $this->table_name . "
             SET user_id = :user_id,
                public_wallet_address = :public_address,
                private_wallet_address = :private_address,
                balance = :balance,
                wallet_type = :wallet_type,
                wallet_key = :wallet_key,
                access_code = :access_code,
                status = :status,
                created = :created";

            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $this->public_wallet_address = htmlspecialchars(strip_tags($this->public_wallet_address));
            $this->private_wallet_address = htmlspecialchars(strip_tags($this->private_wallet_address));
            $this->balance = htmlspecialchars(strip_tags($this->balance));
            $this->wallet_type = htmlspecialchars(strip_tags($this->wallet_type));
            $this->wallet_key = htmlspecialchars(strip_tags($this->wallet_key));
            $this->access_code = htmlspecialchars(strip_tags($this->access_code));
            $this->status = htmlspecialchars(strip_tags($this->status));
            $this->created = htmlspecialchars(strip_tags($this->created));

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":public_address", $this->public_wallet_address);
            $stmt->bindParam(":private_address", $this->private_wallet_address);
            $stmt->bindParam(":balance", $this->balance);
            $stmt->bindParam(":wallet_type", $this->wallet_type);
            $stmt->bindParam(":wallet_key", $this->wallet_key);
            $stmt->bindParam(":access_code", $this->access_code);
            $stmt->bindParam(":status", $this->status);
            $stmt->bindParam(":created", $this->created);

            if($stmt->execute()){
                return true;
            }else{
                $this->showError($stmt);
                return false;
            }
        }

        function getWalletByUser($user_id){
            $user_id = intval($user_id);

            $query = "SELECT * FROM " . $this->table_name . "
                WHERE user_id = {$user_id}
                LIMIT 0,1";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $this->user_id = $row["user_id"];
                $this->public_wallet_address = $row["public_wallet_address"];
                $this->balance = $row["balance"];
                $this->wallet_type = $row["wallet_type"];
                $this->wallet_key = $row["wallet_key"];
                $this->access_code = $row["access_code"];
                $this->status = $row["status"];
                $this->created = $row["created"];
            }
            return $stmt;
        }

        function deleteWallet($user_id){
            $query = "DELETE FROM " . $this->table_name . "
                WHERE user_id = {$user_id}";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }

        function getUserIdByAddress($wallet_address){
            $query = "SELECT * FROM " . $this->table_name . "
            WHERE public_wallet_address = '{$wallet_address}'
            LIMIT 0,1";
        
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $this->user_id = $row['user_id'];
                return true;
            }
            return false;
        }
        function walletExists($wallet_address){
            $query = "SELECT * FROM " . $this->table_name . "
             WHERE public_wallet_address = '{$wallet_address}'
                LIMIT 0,1";
        
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0){
                return true;
            }
            return false;
        }

        function compareBalance($amount, $wallet_address){
            $query = "SELECT * FROM " . $this->table_name . "
             WHERE public_wallet_address = '{$wallet_address}'
                LIMIT 0,1";
        
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if(floatval($row['balance']) >= floatval($amount)){
                    return true;
                }
            }
            return false;
        }
        function updatebalance($wallet_address){
            $query = "UPDATE " . $this->table_name . "
             SET balance = :balance
                WHERE public_wallet_address = '{$wallet_address}'";
        
            $this->balance = htmlspecialchars(strip_tags($this->balance));
            
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":balance", $this->balance);
            
            if($stmt->execute()){
                return true;
            }else{
                $this->showError($stmt);
                return false;
            }

        }

        function deductAmount($wallet_address, $amount){
            $query = "SELECT * FROM " . $this->table_name . "
            WHERE public_wallet_address = '{$wallet_address}'
            LIMIT 0,1";
        
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $this->balance = floatval($row['balance']) - floatval($amount);

                if($this->updatebalance($wallet_address)){
                    return true;
                }
            }
            return false;
        }

        function addAmount($wallet_address, $amount){
            $query = "SELECT * FROM " . $this->table_name . "
                WHERE public_wallet_address = '{$wallet_address}'
                LIMIT 0,1";
        
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $this->balance = floatval($row['balance']) + floatval($amount);

                if($this->updatebalance($wallet_address)){
                    return true;
                }
            }
            return false;
        }

        function calculateWalletGross(){
            $query = "SELECT * FROM " . $this->table_name . "
             ORDER BY created ASC";
        
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0){
                $wallet_gross = 0;

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $wallet_gross += intval($row['balance']);
                }

                return $wallet_gross;
            }
            return 0;
        }
    }
?>