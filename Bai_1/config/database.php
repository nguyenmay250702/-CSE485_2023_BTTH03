<?php
class Database{
    const username = 'root';         
    const password = '';         
    private $conn=null;
    public function __Construct(){
        try {                                                               // Try following code
            $pdo = new PDO("mysql:host=localhost;dbname=btth03_b1;port=3306;charset=utf8mb4", self::username,self::password);  
            $this->conn = $pdo;         
        } catch (PDOException $e) {                                         // If exception thrown
            throw new PDOException($e->getMessage(), $e->getCode());        // Re-throw exception
        }
    }

    public function runSql(string $sql,array $arguments=null)
    {
        if (!$arguments) {                               // If no arguments
            return $this->conn->query($sql);                   // Run SQL, return PDOStatement object
        }
        $statement = $this->conn->prepare($sql);               // If still running prepare statement
        $statement->execute($arguments);                 // Execute SQL statement with arguments
        return $statement;                               // Return PDOStatement object
    }

    public function isActivate(array $arguments){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE `email`=':email' AND `status`=0");
        $stmt->execute($arguments);
        $result = $stmt->fetchAll();

        if(count($result)==0) return true;  //email đã đc kích hoạt
        else return false;  //email chưa đc kích hoạt
    }

}
?>