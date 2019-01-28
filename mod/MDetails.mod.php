<?php
class MDetails {
    
    const ONLY_KEY = 1;
    
    private $conn;
    private $value;
    private $primary_key;
    
    /**
     * Constructeur de MDetails()
     * @param $_primary_key
     */
    public function __construct() {
        $this->conn = new PDO(DATABASE, LOGIN, PASSWORD);
        $this->primary_key = self::ONLY_KEY;
        
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
        $query = 'SELECT * FROM details WHERE id = :id';
        
        $result = $this->conn->prepare($query);
        $result->bindValue(':id', $this->primary_key, PDO::PARAM_INT);
        
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        return $result->fetch();
    }// Select()
    
    
    /**
     * Permet la modification de la base de donnée
     * (insertion, mise à jour et suppression)
     * 
     * @param string $_type     type de modification: insert | update | delete
     * @return void
     */
    public function modify($_type) {
        switch ($_type) {
            case 'Update':      return $this->Update();     break;
        }
        
        return;
    } // modify($_type)
    
    
    /**
     * Mise à jour des informations sur les coordonnées 
     * adresse, numéro de téléphone, fax et d'urgences,
     * de la photo de présentation.
     * 
     * return none;
     */
    private function Update() {
//         var_dump($this->value);
        
        $location = $this->addressToLocation();
        
        $query = 'UPDATE details SET street = :street, postal_code = :postal_code, city = :city, phone = :phone, fax = :fax, emergency = :emergency, latitude = :lat, longitude = :lng,';
        
        if ($this->value['PHOTO'] || (isset($this->value['DEL_PHOTO']) && $this->value['DEL_PHOTO'])) {
            $query .= ' photo_src = :photo_src,';
        }
        
        $query .= ' photo_alt = :photo_alt WHERE id = :id';
        
        $result = $this->conn->prepare($query);
        
            $result->bindValue(':street', $this->value['STREET'], PDO::PARAM_STR);
            $result->bindValue(':postal_code', $this->value['POSTAL_CODE'], PDO::PARAM_STR);
            $result->bindValue(':city', $this->value['CITY'], PDO::PARAM_STR);
            $result->bindValue(':phone', $this->value['PHONE'], PDO::PARAM_STR);
            $result->bindValue(':fax', $this->value['FAX'], PDO::PARAM_STR);
            $result->bindValue(':emergency', $this->value['EMERGENCY'], PDO::PARAM_STR);
            $result->bindValue(':lat', $location['lat'], PDO::PARAM_STR);
            $result->bindValue(':lng', $location['lng'], PDO::PARAM_STR);
            
            if ($this->value['PHOTO']) { 
                $result->bindValue(':photo_src', $this->value['PHOTO'], PDO::PARAM_STR); 
            } elseif (isset($this->value['DEL_PHOTO']) && $this->value['DEL_PHOTO']) {
                $result->bindValue(':photo_src', null, PDO::PARAM_STR);
                $this->value['PHOTO_ALT'] = null;
            }
            
            $result->bindValue(':photo_alt', $this->value['PHOTO_ALT'], PDO::PARAM_STR);
            $result->bindValue(':id', $this->primary_key, PDO::PARAM_STR);
        
        $result->execute() || die($this->errorLog($result->errorInfo()));
        
        if ($this->value['PHOTO'] || $this->value['DEL_PHOTO']) {
            if (file_exists(UP_ACCUEIL . $this->value['OLD_PHOTO'])) {
                unlink(UP_ACCUEIL . $this->value['OLD_PHOTO']);
            }
        }
        
        return;
    }// Update()
    
    /**
     * Affiche les erreurs SQL si ERROR_SQL = true;
     * 
     * @param array $_errorInfo
     */
    private function errorLog($_errorInfo) {
        if (ERROR_SQL) {
            var_dump($_errorInfo);
        }
        
        return;
    }// errorLog($_errorInfo)
    
    /**
     * Convertion de l'adresse postal en coordonnées géographie (longitude, latitude).
     * 
     * @return array contenant les coordonnées de l'adresse.
     */
    private function addressToLocation() {
        $data = array(
            'address'     =>      $this->value['STREET'] .', '. $this->value['POSTAL_CODE'] .', '. $this->value['CITY'],
            'key'         =>        GOOGLE_API_KEY
        );
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?'. http_build_query($data);
        $json = json_decode(file_get_contents($url), true);
        
         return $json['results'][0]['geometry']['location'];
    }// addressToLocation()
    
    /**
     * Renvoie les informations nécessaire à l'API GoogleMap.
     * 
     * @return array contenant la latitude, la longitude et les coordonnées 
     * à afficher dans la fenetre d'information.
     */
    public function mapData() {
        $data = $this->Select();
        
        $spanFax = ($data['fax']) ? '<span class="cell">Fax: '. $data['fax'] .'</span>' : null;
        
        $content = <<<HERE
<section id="mapInfo">
    <h2><img src="../img/catclinic_v2.3.2.png" alt="logo de cat clinic" /></h2>
    <p>
        <span class="cell"><abbr title="téléphone">Tél</abbr>: {$data['phone']}</span>
        $spanFax
        <span class="cell emergency"><strong>Urgences: {$data['emergency']}</strong></span>
            
        <span class="cell"> {$data['street']}</span>
        <span class="cell">{$data['postal_code']} {$data['city']}</span>
    </p>
</section>
HERE;

        return array('lat' => $data['latitude'], 'lng' => $data['longitude'], 'info' => $content);
    }
}