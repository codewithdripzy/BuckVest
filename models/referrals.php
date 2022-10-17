<?php
    class Referral{
        public $id;
        public $referral_id;
        public $referred_id;
        public $token;
        public $created;

        private $table_name = "referrals";
        private $conn;
        
        function __construct($db)
        {
            $this->conn = $db;
        }

        function showError($e){
            echo "<pre>";
                print_r($e);
            echo "</pre>";
        }

        function referUser(){
            $this->created = date("d-m-y H:I:Sa");

            $query = "INSERT INTO " . $this->table_name . "
                SET referral_id = :referral_id,
                    referred_id = :referred_id,
                    token = :token,
                    created = :created";
            
            $this->referral_id = htmlspecialchars(strip_tags($this->referral_id));
            $this->referred_id = htmlspecialchars(strip_tags($this->referred_id));
            $this->token = htmlspecialchars(strip_tags($this->token));

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":referral_id", $this->referral_id);
            $stmt->bindParam(":referred_id", $this->referred_id);
            $stmt->bindParam(":token", $this->token);
            $stmt->bindParam(":created", $this->created);

            if($stmt->execute()){
                return true;
            }else{
                $this->showError($stmt);
                return false;
            }
        }

        function readRefferals($user_id){
            $query = "SELECT * FROM " . $this->table_name . "
            WHERE referral_id = {$user_id}
            ORDER BY created ASC";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }


        function isRefferal($user_id){
            $query = "SELECT * FROM " . $this->table_name . "
            WHERE referral_id = {$user_id}
            LIMIT 0,1";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0){
                return true;
            }
            return false;
        }

        function readAll(){
            $query = "SELECT * FROM " . $this->table_name . "
            ORDER BY created ASC";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
        }
    }
