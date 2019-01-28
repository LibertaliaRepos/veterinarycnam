<?php
class VAccueil {
    
    public function __construct() {}
    
    public function __destruct() {}
    
    public function showAccueil($_data) {
//         var_dump($_data);
        
        $gridXOne = $this->gridXOne($_data['details']);
        $gridXTwo = $this->gridXTwo($_data);
        
        echo <<<HERE
<nav class="cell ariane">
    <ul class="breadcrumbs">
        <li><span class="show-for-sr">Current: </span>Accueil</li>
    </ul>
</nav>
<article id="grid-x-one" class="grid-x grid-margin-x" aria-label="Accueil">
    $gridXOne
</article>

<article id="grid-x-two" class="grid-x grid-margin-x" aria-label="Coordonnées et horaires">
    $gridXTwo
</article>
HERE;
    }
    
    private function gridXOne($_data) {
        $gridXOne = <<<HERE
<section class="cell large-4 large-offset-1">
    <h2>Présentation</h2>
    <p>
        Nous sommes spécialisé dans les soins apportés aux <strong>félins</strong> tel que les chats, les tigres, les hyenes, les lions, etc.<br />
        Notre matériel de dernière génération nous permet de pratiquer des échographies et des radiographies.
        Nous possaidons aussi un laboratoire, un service de cytologie (étude des cellules) ainsi qu'un service d'hospitalisation.

        La compétense de nos docteurs vétérinaires nous permet de pratiquer dentisterie et chirurgie.<br />

        Notre service de garde est ouvert 24h/24 et 7j/7.
        <strong class="emergency">N° d'urgence : {$_data['emergency']}</strong>
    </p>
</section>
<section class="cell large-4 large-offset-2">
    <h2>Rendez-vous</h2>
    <p>
        <strong>Sauf urgences, nous prennons que sur rendez-vous.</strong>
        Vous pouvez prendre rendez-vous en appellant le <strong>{$_data['phone']}</strong> ou vous rendre à l'accueil de la clinique.<br />

        En vous inscrivant, vous pourrez aussi prendre rendez-vous directement depuis le site. Pour cela il faut remplir le formulaire de demande de rendez-vous. <strong>Essayez de donner le plus de détails possible lors de la demande de rendez-vous car cela nous permettera d'ajuster le rendez-vous afin qu'il corresponde le plus possible à votre animal.</strong>
        <a class="inscription-button" href="../php/index.php?EX=userSpace" alt="Inscription" title="inscription"></a>
    </p>
</section>
HERE;

        return $gridXOne;
    }
    
    public function gridXTwo($_data) {
        $vSchedules = new VSchedules();
        $sched = $vSchedules->showPublicSchedules($_data['schedules']);
        
        // Liste des docteurs
        $liDoc = '';
        foreach ($_data['doctors'] as $doc) {
            $liDoc .= '<li><abbr title="docteur">Dr</abbr>. '.$doc['firstname'].' '.$doc['name'].'</li>';
        }
        
        $img = '<p id="detailsPhoto" class="cell large-auto medium-4"><img src="../upload/accueil/'. $_data['details']['photo_src'] .'" alt="'. $_data['details']['photo_alt'] .'" /></p>';
        
        
        // Adresse et numéro
        $spanFax = ($_data['details']['fax']) ? '<span class="cell">Fax: '. $_data['details']['fax'] .'</span>' : null;
        
        $details = <<<HERE
<section id="details" class="cell large-3 grid-x" aria-label="Nous contacter">
    <ul class="cell">
        $liDoc
    </ul>
    <p class="cell grid-x">
        <span class="cell"><abbr title="téléphone">Tél</abbr>: {$_data['details']['phone']}</span>
        $spanFax
        <span class="cell emergency"><strong>Urgences: {$_data['details']['emergency']}</strong></span>
        
        <span class="cell">{$_data['details']['street']}</span>
        <span class="cell">{$_data['details']['postal_code']} {$_data['details']['city']}</span>
    </p>
</section>
HERE;

        return $sched.$img.$details;
    }
    
    
}