<?php
class MAnswer {
    
    static function counterStatus($_status1 , $_status2 = null) {
        $query = 'SELECT COUNT(*) FROM answer WHERE status = :status1';
        
        if ($_status2) {
            $query .= ' OR status = :status2';
        }
        
        $result = $this->conn->prepare($query);
        $result->bindValue(':status1', $_status1, PDO::PARAM_INT);
        if ($_status2) {
            $result->bindValue(':status2', $_status2, PDO::PARAM_INT);
        }
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        return $result->fetch();
    }
    
    private $conn;
    private $value;
    private $primay_key;
    
    /**
     * Constructeur de la class MEployees
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
    
    
    public function Select() {
        $query = 'SELECT ans.*, req.*, mem.firstname, mem.name, mem.label, mem.phone, emp.firstname, emp.name FROM
                    (member AS mem JOIN answer AS ans ON mem.id = ans.id_user)
                        JOIN employees AS emp ON ans.id_doc = emp.id
                            LEFT JOIN request AS req ON req.id_req = ans.id_req
                                WHERE ans.id_answer = :id_answer';
        
        $result = $this->conn->prepare($query);
        $result->bindValue(':id_answer', $this->primary_key, PDO::PARAM_INT);
        
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        return $result->fetch();
    }
    
    public function SelectAll() {
        $query = 'SELECT ans.*, req.pet_name, req.specie, req.age, mem.firstname, mem.name FROM
                    (member AS mem JOIN answer AS ans ON mem.id = ans.id_user)
                        LEFT JOIN request AS req ON req.id_req = ans.id_req';
        
        $result = $this->conn->prepare($query);
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        return $result->fetchAll();
    }
     
    public function modify($_type) {
        switch ($_type) {
            case 'Insert':      $this->Insert();        break;
            case 'Delete':      $this->Delete();        break;
        }
    }
    
    
    private function Insert() {
        
//         var_dump($this->value);
        
        $query = 'INSERT INTO answer(id_req, id_doc, id_user, appointment_date, vet_comment, pdf)
                                VALUES(:id_req, :id_doc, :id_user, :appointment_date, :vet_comment, :pdf)';
        
        $date = mktime($this->value['post']['TIME_H'], $this->value['post']['TIME_MIN'], 0, $this->value['post']['DATE_MONTH'], $this->value['post']['DATE_DAY'], $this->value['post']['DATE_YEAR']);
        
        $result = $this->conn->prepare($query);
            $result->bindValue(':id_req', $this->value['current_mail']['id_req'], PDO::PARAM_INT);
            $result->bindValue(':id_doc', $this->value['post']['DOCTOR']['id'], PDO::PARAM_INT);
            $result->bindValue(':id_user', $this->value['current_mail']['id_user'], PDO::PARAM_INT);
            $result->bindValue(':appointment_date', $date, PDO::PARAM_INT);
            $result->bindValue(':vet_comment', $this->value['post']['DOCTOR_REQU'], PDO::PARAM_STR);
            $result->bindValue(':pdf', $this->value['current_mail']['pdf'], PDO::PARAM_STR);
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        $mReq = new MRequest($this->value['current_mail']['id_req']);
        $mReq->UpdateStatus(SENT_MESSAGE);
    }
    
    private function Delete() {
        $query = 'DELETE ans, req FROM
                    answer As ans JOIN request AS req ON ans.id_req = req.id_req
                        WHERE ans.id_answer = :id_answer';
        
        $pdf = $this->Select()['pdf'];
        
        $result = $this->conn->prepare($query);
            $result->bindValue(':id_answer', $this->primary_key, PDO::PARAM_INT);
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        if (file_exists(UP_PDF . $pdf)) {
            unlink(UP_PDF . $pdf);
        }
    }
    
    
        
    
    private function errorLog($_errorInfo) {
        if (ERROR_SQL) {
            var_dump($_errorInfo);
        }
        
        return;
    }// errorLog($_errorInfo)
}