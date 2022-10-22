<?php
    class Transction{
        public $id;
        public $from_wallet_address;
        public $to_wallet_address;
        public $previous_hash;
        public $current_hash;
        public $amount;
        public $description;
        public $token;
        public $transaction_type;
        public $status;
        public $created;

        private $table_name = "transactions";
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
        
        function createBlock(){
            $this->created = date("y-m-d H:i:s");

            $query = "INSERT INTO " . $this->table_name . "
                SET from_wallet_address = :from_wallet_address,
                    to_wallet_address = :to_wallet_address,
                    previous_hash = :previous_hash,
                    current_hash = :current_hash,
                    amount = :amount,
                    description = :description,
                    token = :token,
                    transaction_type = :transaction_type,
                    status = :status,
                    created = :created";
            
            $this->from_wallet_address = htmlspecialchars(strip_tags($this->from_wallet_address));
            $this->to_wallet_address = htmlspecialchars(strip_tags($this->to_wallet_address));
            $this->previous_hash = htmlspecialchars(strip_tags($this->previous_hash));
            $this->current_hash = htmlspecialchars(strip_tags($this->current_hash));
            $this->amount = htmlspecialchars(strip_tags($this->amount));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->token = htmlspecialchars(strip_tags($this->token));
            $this->transaction_type = htmlspecialchars(strip_tags($this->transaction_type));
            $this->status = htmlspecialchars(strip_tags($this->status));
            $this->created = htmlspecialchars(strip_tags($this->created));

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":from_wallet_address",  $this->from_wallet_address);
            $stmt->bindParam(":to_wallet_address",  $this->to_wallet_address);
            $stmt->bindParam(":previous_hash",  $this->previous_hash);
            $stmt->bindParam(":current_hash",  $this->current_hash);
            $stmt->bindParam(":amount",  $this->amount);
            $stmt->bindParam(":description",  $this->description);
            $stmt->bindParam(":token",  $this->token);
            $stmt->bindParam(":transaction_type",  $this->transaction_type);
            $stmt->bindParam(":status",  $this->status);
            $stmt->bindParam(":created",  $this->created);

            if($stmt->execute()){
                return true;
            }else{
                $this->showError($stmt);
                return false;
            }

            return $stmt;
        }

        function deleteBlock($from_wallet_address){
            $query = "DELETE FROM " .  $this->table_name . "
            WHERE from_wallet_address = '{$from_wallet_address}'";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();
            return $stmt;
        }

        function readTransactionBlocksById($from_wallet_address){
            $query = "SELECT * FROM " .  $this->table_name . "
            WHERE from_wallet_address = '{$from_wallet_address} AND transaction_type = 'transfer'
            ORDER BY created ASC";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();
            return $stmt;
        }

        function readUserTransaction($wallet_address, $transaction_type){
            if($transaction_type == 'deposit'){
                $query = "SELECT * FROM " .  $this->table_name . "
                 WHERE to_wallet_address = '{$wallet_address}'
                 AND transaction_type = 'deposit'
                ORDER BY created ASC";
            }else{
                $query = "SELECT * FROM " .  $this->table_name . "
                WHERE from_wallet_address = '{$wallet_address}'
                AND transaction_type = '{$transaction_type}'
                ORDER BY created ASC";
            }
            $stmt = $this->conn->prepare($query);

            $stmt->execute();
            return $stmt;
        }

        function readTransactionBlocksByType($type){
            $query = "SELECT * FROM " .  $this->table_name . "
            WHERE transaction_type = '{$type}'
            ORDER BY created ASC";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();
            return $stmt;
        }

        function readOtherTransactionBlocksByType(){
            $query = "SELECT * FROM " .  $this->table_name . "
             WHERE transaction_type = 'transfer'
             ORDER BY created ASC";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();
            return $stmt;
        }

        function getWithdrawals(){
            $query = "SELECT * FROM " .  $this->table_name . "
             WHERE transaction_type = 'withdrawal'
             ORDER BY created ASC";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();
            return $stmt;
        }

        function readAll(){
            $query = "SELECT * FROM " .  $this->table_name . "
            ORDER BY created ASC";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();
            return $stmt;
        }

        function verifyTransaction($token, $wallet_address, $transaction_type){
            if($transaction_type == "withdrawal"){
                $query = "UPDATE " .  $this->table_name . "
                SET status = 1
                WHERE token = '{$token}' AND from_wallet_address = '{$wallet_address}' AND transaction_type = '{$transaction_type}'";
            }else{
                $query = "UPDATE " .  $this->table_name . "
                SET status = 1
                WHERE token = '{$token}' AND to_wallet_address = '{$wallet_address}' AND transaction_type = '{$transaction_type}'";
            }
        
            $stmt = $this->conn->prepare($query);

            if($stmt->execute()){
                $this->readOne($token, $wallet_address, $transaction_type);
                return true;
            }
            return false;
        }

        function readOne($token, $wallet_address, $transaction_type){
            $query = "SELECT * FROM " .  $this->table_name . "
                WHERE token = '{$token}' AND to_wallet_address = '{$wallet_address}' AND
                transaction_type = '{$transaction_type}'
                LIMIT 0,1";
                
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $this->amount = $row['amount'];
                return true;
            }
            return false;
        }
        
        function readOneTransactionBlock($transaction_id){
            $query = "SELECT * FROM " .  $this->table_name . "
            WHERE id = '{$transaction_id}'
            ORDER BY created ASC
            LIMIT 0,1";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();
            return $stmt;
        }

        function getPreviousHash(){
            $query = "SELECT * FROM " .  $this->table_name . "
            ORDER BY created DESC
            LIMIT 0,1";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                return $row["current_hash"];
            }
            return false;
        }

        function calculateCashflow(){
            $query = "SELECT * FROM " .  $this->table_name . "
            WHERE transaction_type != 'genesys'
            ORDER BY created ASC";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0){
                $cashflow = 0;

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    if($row["transaction_type"] == "deposit" || $row["transaction_type"] == "transfer"){
                        $cashflow += intval($row["amount"]);
                    }else if($row["transaction_type"] == "withdrawal"){
                        $cashflow -= intval($row["amount"]);
                    }
                }
                return $cashflow;
            }
            return 0;
        }

        function calculateWithdrawals(){
            $query = "SELECT * FROM " .  $this->table_name . "
            WHERE transaction_type = 'withdrawal'
            ORDER BY created ASC";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0){
                $cashflow = 0;

                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $cashflow += intval($row["amount"]);
                }
                return $cashflow;
            }
            return 0;
        }

        function deleteTransaction($token, $wallet_address, $transaction_type){
            $query = "DELETE FROM " .  $this->table_name . "
            WHERE token = '{$token}' AND to_wallet_address = '{$wallet_address}' AND transaction_type = '{$transaction_type}'";

            $stmt = $this->conn->prepare($query);

            if($stmt->execute()){
                return true;
            }
            return false;
        }
        
        function getTransactionByType($to_wallet_address, $token, $transaction_type){
            $query = "SELECT * FROM " . $this->table_name . "
            WHERE to_wallet_address = '{$to_wallet_address}' AND token = '{$token}'
            AND transaction_type = '{$transaction_type}'
            ORDER BY created ASC";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $this->from_wallet_address = $row['from_wallet_address'];
                $this->to_wallet_address = $row['to_wallet_address'];
                $this->amount = $row['amount'];
                $this->token = $row['token'];
                $this->created = $row['created'];

                return true;
            }
            return false;
        }
    }
?>