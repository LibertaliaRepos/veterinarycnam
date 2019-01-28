<?php 
class MEmployees {
    
    const EMPTY_AVATAR = 'emptyAvatar.png';
    
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
    
    /**
     * 
     */
    public function __destruct() {}
    
    /**
     * Instancie le membre $value.
     * 
     * @param unknown $_value
     */
    public function setValue($_value) {
        $this->value = $_value;
    }
    
    /**
     * Renvoie le tuple correspondant à un employé.
     * 
     * @return mixed
     */
    public function Select() {
        $query ='SELECT * FROM employees WHERE id = :id';
        
        $result = $this->conn->prepare($query);
        $result->bindValue(':id', $this->primary_key, PDO::PARAM_INT);
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        return $result->fetch();
    }
    
    /**
     * Retourne tous les tuples des remployés par ordre alphabetique des noms.
     * 
     * @return array
     */
    public function SelectAll() {
        $query = 'SELECT * FROM employees ORDER BY name';
        
        $result = $this->conn->prepare($query);
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        return $result->fetchAll();
    }
    
    /**
     * Renvoie les tous les tuples correspondants aux docteurs.
     * 
     * @return array
     */
    public function SelectAllDoctor() {
        $query = 'SELECT id, name, firstname FROM employees WHERE job = :job ORDER BY name';
        
        $result = $this->conn->prepare($query);
        $result->bindValue(':job', 'Docteur', PDO::PARAM_STR);
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        return $result->fetchAll();
    }
    
    /**
     * Donne accès aux métodes de modification de 
     * la base de données
     * @param string $_type type de modification : Insert
     */
    public function modify($_type) {
        switch ($_type) {
            case 'Insert':      $this->Insert();        break;
            case 'Update':      $this->Update();        break;
            case 'Delete':      $this->Delete();        break;
        }
    }// modify($_type)
    
    /**
     * Insertion d'un employé dans la table.
     */
    private function Insert() {
        $this->value['PHOTO'] = ($this->value['PHOTO']) ? $this->value['PHOTO'] : 'emptyAvatar.png';
        
        $query = 'INSERT INTO employees(name, firstname, hiring_date, job, description, photo)
                                    VALUES(:name, :firstname, :hiring_date, :job, :description, :photo)';
        
        $hiringDate = mktime(0,0,0,intval($this->value['MONTH']), intval($this->value['DAY']), intval($this->value['YEAR']));
        
        $result = $this->conn->prepare($query);
        $result->bindValue(':name', $this->value['NAME'], PDO::PARAM_STR);
        $result->bindValue(':firstname', $this->value['FIRSTNAME'], PDO::PARAM_STR);
        $result->bindValue(':hiring_date', $hiringDate, PDO::PARAM_INT);
        $result->bindValue(':job', $this->value['JOB'], PDO::PARAM_STR);
        $result->bindValue(':description', $this->value['DESCRIPTION'], PDO::PARAM_STR);
        $result->bindValue(':photo', $this->value['PHOTO'], PDO::PARAM_STR);
        
        $result->execute() || die($this->errorLog($result->errorInfo()));
    }
    
    /**
     * Mise à jour d'un employé.
     */
    private function Update() {
        $query = 'UPDATE employees SET name = :name, firstname = :firstname, hiring_date = :hiring_date, job = :job, description = :description';
        
        if ($this->value['PHOTO'] || isset($this->value['DEL_PHOTO'])) {
            $query .= ', photo = :photo';
            
            if ($this->value['DEL_PHOTO']) {
                $this->value['PHOTO'] = self::EMPTY_AVATAR;
            }
        }
        
        $query .= ' WHERE id = :id';
        
        $hiringDate = mktime(0,0,0,intval($this->value['MONTH']), intval($this->value['DAY']), intval($this->value['YEAR']));
        
        $result = $this->conn->prepare($query);
        $result->bindValue(':name', $this->value['NAME'], PDO::PARAM_STR);
        $result->bindValue(':firstname', $this->value['FIRSTNAME'], PDO::PARAM_STR);
        $result->bindValue(':hiring_date', $hiringDate, PDO::PARAM_INT);
        $result->bindValue(':job', $this->value['JOB'], PDO::PARAM_STR);
        $result->bindValue(':description', $this->value['DESCRIPTION'], PDO::PARAM_STR);
        
        if ($this->value['PHOTO'] || isset($this->value['DEL_PHOTO'])) {
            $result->bindValue(':photo', $this->value['PHOTO'], PDO::PARAM_STR);
        }
        
        $result->bindValue(':id', $this->primary_key, PDO::PARAM_INT);
        
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        if(($this->value['PHOTO'] && $this->value['OLD_PHOTO'] != self::EMPTY_AVATAR ) || isset($this->value['DEL_PHOTO'])) {
            unlink(UP_EMPLOYEES . $this->value['OLD_PHOTO']);
        }
    }
    
    /**
     * Suppression d'un employé. 
     * Puis suppression de sa photo. 
     */
    private function Delete() {
        $query = 'DELETE FROM employees WHERE id = :id';
        
        $photo = $this->Select()['photo'];
        
        $result = $this->conn->prepare($query);
        $result->bindValue(':id', $this->primary_key, PDO::PARAM_INT);
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        if($photo != self::EMPTY_AVATAR) {
            unlink(UP_EMPLOYEES . $photo);
        }
    }
    
    private function errorLog($_errorInfo) {
        if (ERROR_SQL) {
            var_dump($_errorInfo);
        }
        
        return;
    }// errorLog($_errorInfo)
}

?>