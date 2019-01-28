<?php
class MSchedules {
    
    const MAX_SCHEDULE_GROUPS = 7;
    
    private $conn;
    private $value;
    private $primary_key;
    private $week = array(
        'lundi'     => null,
        'mardi'     => null,
        'mercredi'  => null,
        'jeudi'     => null,
        'vendredi'  => null,
        'samedi'    => null,
        'dimanche'  => null,
        'group'     => null
    );
    
    public function __construct($_primary_key = null) {
        $this->conn = new PDO(DATABASE, LOGIN, PASSWORD);
        
        $this->primary_key=$_primary_key;
    }
    
    public function __destruct() {}
    
    public function setValue($_value) {
        $this->value = $_value;
    }
    
    public function selectAll() {
        $query = 'SELECT * FROM `schedules-v2.0` ORDER BY id';
        
        $result = $this->conn->prepare($query);
        $result->execute() || die($result->errorInfo());
        return $result->fetchAll();
    }
    
    public function modify($_type) {
        switch ($_type) {
            case 'Insert':      $this->Insert();        break;
        }
    }
    
    
    private function Insert() {
        var_dump($this->value);
        
        $this->truncate();
        
        $query = 'INSERT INTO `schedules-v2.0`(schedule_group, Lundi, Mardi, Mercredi, Jeudi, Vendredi, Samedi, Dimanche)
                                            VALUES(:group, :Lundi, :Mardi, :Mercredi, :Jeudi, :Vendredi, :Samedi, :Dimanche)';
        $result = $this->conn->prepare($query);
        
        for ($i = 0; $i < self::MAX_SCHEDULE_GROUPS && isset($this->value[$i .'-SCHED']); ++$i) {
            $this->week = array(
                'group'     => (isset($this->value[$i .'-SCHED'])) ? $this->value[$i .'-SCHED'] : false,
                'Lundi'     => (isset($this->value[$i .'-Lundi'])) ?    true : false,
                'Mardi'     => (isset($this->value[$i .'-Mardi'])) ?    true : false,
                'Mercredi'  => (isset($this->value[$i .'-Mercredi'])) ? true : false,
                'Jeudi'     => (isset($this->value[$i .'-Jeudi'])) ?    true : false,
                'Vendredi'  => (isset($this->value[$i .'-Vendredi'])) ? true : false,
                'Samedi'    => (isset($this->value[$i .'-Samedi'])) ?   true : false,
                'Dimanche'  => (isset($this->value[$i .'-Dimanche'])) ? true : false
            );
            foreach ($this->week as $key => $value) {
                if ($key == 'group') {
                    $result->bindValue(":$key", $value, PDO::PARAM_STR);
                } else {
                    $result->bindValue(":$key", $value, PDO::PARAM_BOOL);
                }
            }
            
            $result->execute() || die($this->errorLog($result->errorInfo()));
        }
    }
    
    private function truncate() {
        $query = 'TRUNCATE TABLE `schedules-v2.0`';
        
        $this->conn->exec($query);
    }
    
    private function errorLog($_errorInfo) {
        if (ERROR_SQL) {
            var_dump($_errorInfo);
        }
        
        return;
    }// errorLog($_errorInfo)
}


























?>