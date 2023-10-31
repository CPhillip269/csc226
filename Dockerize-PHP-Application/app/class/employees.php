<?php
    class Employee{

        // Connection
        private $conn;

        // Table
        private $db_table = "Employee";

        // Columns
        public $id;
        public $name;
        public $email;
        public $pay;
        public $position;
        public $hired;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getEmployees(){
            $sqlQuery = "SELECT id, name, email, pay, position, hired FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createEmployee(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        email = :email, 
                        pay = :pay, 
                        position = :position, 
                        hired = :hired";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->pay=htmlspecialchars(strip_tags($this->pay));
            $this->position=htmlspecialchars(strip_tags($this->position));
            $this->hired=htmlspecialchars(strip_tags($this->hired));
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":pay", $this->pay);
            $stmt->bindParam(":position", $this->position);
            $stmt->bindParam(":hired", $this->hired);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // UPDATE
        public function getSingleEmployee(){
            $sqlQuery = "SELECT
                        id, 
                        name, 
                        email, 
                        pay, 
                        position, 
                        hired
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->name = $dataRow['name'];
            $this->email = $dataRow['email'];
            $this->pay = $dataRow['pay'];
            $this->position = $dataRow['position'];
            $this->hired = $dataRow['hired'];
        }        

        // UPDATE
        public function updateEmployee(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        email = :email, 
                        pay = :pay, 
                        position = :position, 
                        hired = :hired
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->pay=htmlspecialchars(strip_tags($this->pay));
            $this->position=htmlspecialchars(strip_tags($this->position));
            $this->hired=htmlspecialchars(strip_tags($this->hired));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":pay", $this->pay);
            $stmt->bindParam(":position", $this->position);
            $stmt->bindParam(":hired", $this->hired);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteEmployee(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
?>

