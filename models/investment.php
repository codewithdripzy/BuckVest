<?php
    class Investment{
        public $id;
        public $user_id;
        public $investment_plan;
        public $amount;
        public $created;
        public $modified;

        private $table_name = "investments";
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

        function invest(){
            $this->created = date("y-m-d H:i:s");

            $query = "INSERT INTO " . $this->table_name . "
             SET user_id = :user_id,
                investment_plan = :investment_plan,
                amount = :amount,
                created = :created";
            
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $this->investment_plan = htmlspecialchars(strip_tags($this->investment_plan));
            $this->amount = htmlspecialchars(strip_tags($this->amount));
            $this->created = htmlspecialchars(strip_tags($this->created));

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":investment_plan", $this->investment_plan);
            $stmt->bindParam(":amount", $this->amount);
            $stmt->bindParam(":created", $this->created);

            if($stmt->execute()){
                return true;
            }else{
                $this->showError($stmt);
                return false;
            }
        }

        function readAll(){
            $query = "SELECT * FROM " . $this->table_name . "
             ORDER BY created ASC";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            return $stmt;
        }

        function readOne($user_id){
            $query = "SELECT * FROM " . $this->table_name . "
             WHERE user_id = {$user_id}
             LIMIT 0,1";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $this->investment_plan = $row["investment_plan"];
                $this->amount = $row["amount"];
                $this->created = $row["created"];

                return true;
            }
            return false;
        }

        function hasInvested($user_id){
            $query = "SELECT * FROM " . $this->table_name . "
            WHERE user_id = {$user_id}
            LIMIT 0,1";

            $stmt = $this->conn->prepare($query);

            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $this->investment_plan = $row["investment_plan"];
                $this->amount = $row["amount"];
                $this->created = $row["created"];

                return true;
            }
           return false;
        }
    }
?>