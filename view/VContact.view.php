<?php
class VContact {
    
    public function __construct() {}
    
    public function __destruct() {}
    
    public function showContact($_data) {
        $vAccueil = new VAccueil();
        
        $gridXOne = $vAccueil->gridXTwo($_data);
        
        echo <<<HERE
<nav class="cell ariane">
    <ul class="breadcrumbs">
        <li><a href="../php/">Accueil</a></li>
        <li><span class="show-for-sr">Current: </span>Contacts</li>
    </ul>
</nav>

<article id="grid-x-one" class="grid-x grid-margin-x contacts-page" aria-label="Contacts">
    $gridXOne
</article>
<article id="grid-x-two" class="grid-x grid-margin-x" aria-label="Coordonnées et horaires">
    <h1>Plan</h1>
    <section id="map" class="" aria-label="Plan Google map">
    </section>
</article>
HERE;
    }
        
    
    public function mapData() {
        $mDetails = new MDetails();
        $data = $mDetails->Select();
        
        $spanFax = ($data['fax']) ? '<span class="cell">Fax: '. $data['fax'] .'</span>' : null;
        
        $content = '<section>
                        <h2>CAT CLINIC</h2>
                        <p>
                            <span class="cell"><abbr title="téléphone">Tél</abbr>: '. $data['phone'] .'</span>
                            $spanFax
                            <span class="cell emergency"><strong>Urgences: '. $data['emergency'] .'</strong></span>
                            
                            <span class="cell"> '. $data['street'] .'</span>
                            <span class="cell">'. $data['postal_code'] .' '.$data['city'] .'</span>
                        </p>
                    </section>';
        
        echo json_encode(array('lat' => $data['latitude'], 'lng' => $data['longitude'], 'info' => $content));;
    }
        
}