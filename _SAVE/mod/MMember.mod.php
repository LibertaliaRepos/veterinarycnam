<?php
class MMember {
    
    private $conn;
    private $value;
    private $primary_key;
    
    /**
     * Constructeur de MMember()
     * @param $_primary_key
     */
    public function __construct($_primary_key = null) {
        $this->conn = new PDO(DATABASE, LOGIN, PASSWORD);
        $this->primary_key = $_primary_key;
        
        return;
    }// __construct($_primary_key = null)
    
    /**
     * Destructeur de MMember()
     */
    public function __destruct() {}
    
    
    /**
     * 
     * @param $_value
     */
    public function setValue($_value) {
        $this->value = $_value;
        
        return;
    }// setValue($_value)
    
    public function Select() {
        $query = 'SELECT * FROM member WHERE id = :id';
        
        $result = $this->conn->prepare($query);
            $result->bindValue(':id', $this->primary_key, PDO::PARAM_INT);
        
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        return $result->fetch();
    }
    
    public function verifUser($_data) {
        $query = 'SELECT * FROM member WHERE email = :email AND password = :password';
        
        $result = $this->conn->prepare($query);
            $result->bindValue(':email', $_data['EMAIL'], PDO::PARAM_STR);
            $result->bindValue(':password', $_data['PWD'], PDO::PARAM_STR);
        
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        return $result->fetch();
    }
    
    public function verifMail($_data) {
        $query = 'SELECT COUNT(*) FROM member WHERE email = :email';
        
        $result = $this->conn->prepare($query);
            $result->bindValue(':email', $_data, PDO::PARAM_STR);
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        return $result->fetch();
        
    }
    
    public function modify($_type) {
        switch ($_type) {
            case 'Insert':      return $this->Insert();     break;
            case 'Update':      return $this->Update();     break;
            case 'Delete':      $this->Delete();            break;
        }
    }
    
    
    
    
    private function Insert() {
        $query = 'INSERT INTO member(label, firstname, name, email, password, sign_up_date, status)
                              VALUES(:label, :firstname, :name, :email, :password, :sign_up_date, :status)';
        
        $result = $this->conn->prepare($query);
            $result->bindValue(':label', $this->value['LABEL'], PDO::PARAM_STR);
            $result->bindValue(':firstname', $this->value['FIRSTNAME'], PDO::PARAM_STR);
            $result->bindValue(':name', $this->value['NAME'], PDO::PARAM_STR);
            $result->bindValue(':email', $this->value['EMAIL'], PDO::PARAM_STR);
            $result->bindValue(':password', $this->value['PWD'], PDO::PARAM_STR);
            $result->bindValue(':sign_up_date', time(), PDO::PARAM_INT);
            $result->bindValue(':status', USER_STAT, PDO::PARAM_INT);
        
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        return $this->Select($this->conn->lastInsertId());
    }
    
    private function Update() {
        $query = 'UPDATE member SET phone = :phone';
        
        if ($this->value['EMAIL'] != null)  { $query .= ', email = :email'; }
        
        if ($this->value['PWD'] != null)    { $query .= ', password = :pwd'; }
        
        $query .= ' WHERE id = :id';
        
        $result = $this->conn->prepare($query);
        
            $result->bindValue(':phone', $this->value['PHONE'], PDO::PARAM_STR);
            if ($this->value['EMAIL'] != null)  { 
                $result->bindValue(':email', $this->value['EMAIL'], PDO::PARAM_STR);
            }
            if ($this->value['PWD'] != null)  {
                $result->bindValue(':pwd', $this->value['PWD'], PDO::PARAM_STR);
            }
            $result->bindValue(':id', $this->primary_key, PDO::PARAM_INT);
        
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        return $this->Select();
    }
    
    private function Delete() {
        $query = 'DELETE FROM  member WHERE id = :id';
        
        $result = $this->conn->prepare($query);
            $result->bindValue(':id', $this->primary_key, PDO::PARAM_INT);
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        return;
    }
    
    private function errorLog($_errorInfo) {
        if (ERROR_SQL) {
            var_dump($_errorInfo);
        }
    }
}