<?php
    class Earnings{
        public $id;
        public $wallet_address;
        public $amount;
        public $token;
        public $created;

        private $table_name = "earnings";
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

        function earn($user_id){
            $query = "INSERT INTO "  .$this->table_name . "
                SET 
                wallet_address = :wallet_address,
                amount = :amount,
                token = :token,
                created = :created";

            $this->wallet_address = htmlspecialchars(strip_tags($this->wallet_address));
            $this->amount = htmlspecialchars(strip_tags($this->amount));
            $this->token = htmlspecialchars(strip_tags($this->token));
            $this->created = htmlspecialchars(strip_tags($this->created));

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":wallet_address", $this->wallet_address);
            $stmt->bindParam(":amount", $this->amount);
            $stmt->bindParam(":token", $this->token);
            $stmt->bindParam(":created", $this->created);

            if($stmt->execute()){
                return true;
            }else{
                $this->showError($stmt);
                return false;
            }
        }

        function readEarnings($wallet_address){
            $query = "SELECT * FROM "  .$this->table_name . "
            WHERE wallet_address = '{$wallet_address}'
            ORDER BY created ASC";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }
    }
?>