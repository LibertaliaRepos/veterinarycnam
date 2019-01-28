<?php
class MHTML {
    
    
    private $conn;
    private $value;
    private $primay_key;
    
    /**
     * Constructeur de la class MHTML
     * @param int $_primary_key
     */
    public function __construct($_primary_key = null) {
        $this->primary_key = $_primary_key;
        $this->conn = new PDO(DATABASE, LOGIN, PASSWORD);
        
        return;
    }// __construct($_primary_key = null)
    
    public function __destruct() {}
    
    public function setValue($_value) {
        $this->value = $_value;
    }
    
    public function SelectByName($_name) {
        $query = 'SELECT html FROM HTML WHERE page_name = :page_name';
        
        $result = $this->conn->prepare($query);
        $result->bindValue(':page_name', $_name, PDO::PARAM_STR);
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        return $result->fetch();
    }
    
    /**
     * Donne accès aux métodes de modification de
     * la bse de données
     * @param string $_type type de modification : Insert
     */
    public function modify($_type) {
        switch ($_type) {
            case 'Insert':      $this->Insert();        break;
            case 'Update':      $this->Update();        break;
        }
    }// modify($_type)
    
    private function Insert() {
        $query = 'INSERT INTO HTML(page_name, html)
                            VALUES(:page_name, :html)';
        
        $result = $this->conn->prepare($query);
            $result->bindValue(':page_name', $this->value['name'], PDO::PARAM_STR);
        $result->bindValue(':html', $this->value['html'], PDO::PARAM_STR);
        
        $result->execute() || die($this->errorLog($result->errorInfo()));
    }
    
    private function Update() {
        $query = 'UPDATE HTML set page_name = :name, html = :html WHERE id = :id';
        
        $result = $this->conn->prepare($query);
            $result->bindValue(':name', $this->value['name'], PDO::PARAM_STR);
            $result->bindValue(':html', $this->value['html'], PDO::PARAM_STR);
            $result->bindValue(':id', $this->primay_key, PDO::PARAM_INT);
        $result->execute() || die($this->errorLog($result->errorInfo()));
    }
    
    private function errorLog($_errorInfo) {
        if (ERROR_SQL) {
            var_dump($_errorInfo);
        }
        
        return;
    }// errorLog($_errorInfo)
}