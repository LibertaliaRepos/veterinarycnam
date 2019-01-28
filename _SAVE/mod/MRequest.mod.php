<?php
class MRequest{
    
    private $conn;
    private $value;
    private $primary_key;
    
    static function counterStatus($_status1 , $_status2 = null) {
        $query = 'SELECT COUNT(*) FROM request WHERE status = :status1';
        
        if ($_status2) {
            $query .= ' OR status = :status2';
        }
        
        $pdo = new PDO(DATABASE, LOGIN, PASSWORD);
        
        $result = $pdo->prepare($query);
        $result->bindValue(':status1', $_status1, PDO::PARAM_INT);
        if ($_status2) {
            $result->bindValue(':status2', $_status2, PDO::PARAM_INT);
        }
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        return $result->fetch();
    }
    
    /**
     * Constructeur de MDetails()
     * @param $_primary_key
     */
    public function __construct($_primary_key = null) {
        $this->conn = new PDO(DATABASE, LOGIN, PASSWORD);
        $this->primary_key = $_primary_key;
        
        return;
    }// __construct($_primary_key = null)
    
    /**
     * Destructeur de MDetails()
     */
    public function __destruct() {}
    
    /**
     *  Instancie le membre $value
     * @param $_value
     */
    public function setValue($_value) {
        $this->value = $_value;
        
        return;
    }// setValue($_value)
    
    /**
     * 
     * @return mixed
     */
    public function Select() {
        $query = 'SELECT req.*, mem.firstname, mem.name, mem.label, mem.email, mem.phone FROM
                    member AS mem JOIN request AS req ON mem.id = req.id_user
                        WHERE req.id_req = :id_req';
        
        $result = $this->conn->prepare($query);
            $result->bindValue(':id_req', $this->primary_key, PDO::PARAM_INT);
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        return $result->fetch();
    }
    
    /**
     * Retourne les tuples des nouveaux rendez-vous.
     * @return array
     */
    public function SelectAll() {
        $query = 'SELECT req.*, mem.firstname, mem.name, mem.label, mem.email FROM
                    (member AS mem JOIN request AS req ON mem.id = req.id_user)
                        LEFT JOIN answer AS ans ON req.id_req = ans.id_req
                            WHERE ans.id_req IS NULL';
        
        $result = $this->conn->prepare($query);
            $result->bindValue(':status', NEW_MESSAGE, PDO::PARAM_INT);
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        return $result->fetchAll();
    }
    
    /**
     * Permet la modification de la base de donnée
     * (insertion, mise à jour et suppression)
     *
     * @param string $_type     type de modification: Insert | Update | delete
     * @return void
     */
    public function modify($_type) {
        switch ($_type) {
            case 'Insert':      $this->Insert();     break;
            case 'Delete':      $this->Delete();     break;
        }
        
        return;
    } // modify($_type)
    
    private function Insert() {
        $query = 'INSERT INTO request(id_user, pet_name, specie, age, sexe, comment, time_req, status)
                                VALUES(:id_user, :pet_name, :specie, :age, :sexe, :comment, :time_req, :status)';
        
        $age = getdate(time())['year'] - $this->value['BORN_YEAR'];
        
        $result = $this->conn->prepare($query);
            $result->bindValue(':id_user', $_SESSION['MEMBER']['id'], PDO::PARAM_STR);
            $result->bindValue(':pet_name', $this->value['NAME'], PDO::PARAM_STR);
            $result->bindValue(':specie', $this->value['SPECIE'], PDO::PARAM_STR);
            $result->bindValue(':age', $age, PDO::PARAM_INT);
            $result->bindValue(':sexe', $this->value['SEXE'], PDO::PARAM_STR);
            $result->bindValue(':comment', $this->value['MOTIF'], PDO::PARAM_STR);
            $result->bindValue(':time_req', time(), PDO::PARAM_INT);
            $result->bindValue(':status', NEW_MESSAGE, PDO::PARAM_INT);
        
        $result->execute() || die($this->errorLog($result->errorInfo()));
    }
    
    public function UpdateStatus($_status) {
        $query = 'UPDATE request SET status = :status WHERE id_req = :id_req';
        
        $result = $this->conn->prepare($query);
            $result->bindValue(':status', $_status, PDO::PARAM_INT);
        $result->bindValue(':id_req', $this->primary_key, PDO::PARAM_INT);
        
        $result->execute() || die($this->errorLog($result->errorInfo()));
    }
    
    private function Delete() {
        $query = 'DELETE FROM request WHERE id_req = :id_req';
        
        $result = $this->conn->prepare($query);
            $result->bindValue(':id_req', $this->primary_key, PDO::PARAM_INT);
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        return;
    }
    
    private function errorLog($_errorInfo) {
        if (ERROR_SQL) {
            var_dump($_errorInfo);
        }
        
        return;
    }// errorLog($_errorInfo)
}