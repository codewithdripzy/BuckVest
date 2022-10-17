<?php
class User
{
    public $id;
    public $fullname;
    public $email;
    public $password;
    public $status;
    public $access_level;
    public $access_code;
    public $created;
    public $modified;

    private $table_name = "users";
    private $conn;
    function __construct($db)
    {
        $this->conn = $db;
    }

    function show_error($e)
    {
        echo "<pre>";
            print_r($e);
        echo "</pre>";
    }

    function createAccount()
    {
        $this->created = date("d-m-y H:i:Sa");

        $query = "INSERT " . $this->table_name . "
            SET fullname = :fullname,
                email = :email,
                password = :password,
                status = :status,
                access_code = :access_code,
                access_level = :access_level,
                created = :created";

        $stmt = $this->conn->prepare($query);

        $this->fullname = htmlspecialchars(strip_tags($this->fullname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->access_code = htmlspecialchars(strip_tags($this->access_code));
        $this->access_level = htmlspecialchars(strip_tags($this->access_level));


        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":email", $this->email);
        $password = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":access_code", $this->access_code);
        $stmt->bindParam(":access_level", $this->access_level);

        $stmt->bindParam(":created", $this->created);

        if ($stmt->execute()) {
            return true;
        } else {
            $this->show_error($stmt);
            return false;
        }
    }

    function emailExist($email)
    {
        $query = "SELECT * FROM " . $this->table_name . "
            WHERE email = '{$email}'
            LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row['id'];
            $this->fullname = $row['fullname'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->access_code = $row['access_code'];
            $this->access_level = $row['access_level'];
            $this->status = $row['status'];
            $this->created = $row['created'];
            $this->modified = $row['modified'];

            return true;
        }

        return false;
    }

    function readOne($user_id)
    {
        $query = "SELECT * FROM " . $this->table_name . "
            WHERE id = '{$user_id}'
            LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        
        $count = $stmt->rowCount();

        if ($count > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->fullname = $row['fullname'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->access_code = $row['access_code'];
            $this->access_level = $row['access_level'];
            $this->status = $row['status'];
            $this->created = $row['created'];
            $this->modified = $row['modified'];

            return true;
        }

        return false;
    }

    function deleteAccount($email){
        $query = "DELETE FROM " . $this->table_name . "
            WHERE email = '{$email}'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function readAll(){
        $query = "SELECT * FROM " . $this->table_name . "
        ORDER BY created ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt; 
    }

    function readAllUsers(){
        $query = "SELECT * FROM " . $this->table_name . "
        WHERE access_level = 'user'
        ORDER BY created ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
