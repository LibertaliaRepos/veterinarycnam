<?php
class VAppointment {
    
    const MIN_BORN_DEPTH = 40;
    // nombre de jour maximum dans un mois
    const MAX_DAYS = 31;
    //
    const MAX_YEAR_DEPTH = 5;
    // Contient tous les mois de l'année.
    const MONTHS = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
    
    public function __construct() {}
    
    public function __destruct() {}
    
    /**
     * Affiche le formulaire pour prendre un rendez-vous.
     */
    public function showRequestForm() {
        
        // Création des <option> pour la séléction de l'année de naissance 
        $bornOpt = '<option value="">Année</option>';
        $currentYear = getdate(time())['year'];
        for($i = 0; $i < self::MIN_BORN_DEPTH; ++$i) {
            $year = $currentYear - $i;
            $bornOpt .= '<option value="'. $year .'">'. $year .'</option>';
        }
        
        echo <<<HERE
<article id="grid-x-one" class="grid-x grid-margin-x">
    <nav class="cell ariane">
        <ul class="breadcrumbs">
            <li><a href="../php/">Accueil</a></li>
            <li>Mon compte</li>
            <li><span class="show-for-sr">Current: </span>Prendre rendez-vous</li>
        </ul>
    </nav>
    <h1 class="cell">Prendre rendez-vous</h1>
    
    <p class="cell large-5 my-margin-auto">
        Pour prendre rendez-vous, vous devez remplir ce formulaire en y indiquant le nom, l'année de naissance, le sexe, l'espèce, ainsi que le motif de celui-ci. Essayez de remplir ce formulaire avec le plus de détails possible car cela nous permettera de vous donner un rendez-vous qui correspond le plus possible a vos attentes. Nous vous répondrons par mail très prochainement. 
    </p>
    
    <form id="takeAppointment" class="cell large-10 large-offset-1 grid-container" action="../php/index.php?EX=userSpace&USER_SPACE=appointment&APPOINTMENT=requestInsert" method="post">
        <p class="help-text">* : Champ obligatoire</p>
        <fieldset class="grid-x grid-margin-x">
            <legend class="cell">Votre animal</legend>
            
            <label for="petName" class="large-3 large-offset-2">* Prénom :</label>
                <input id="petName" class="large-4" type="text" name="NAME" required/>
            
            <label for="bornSelect" class="large-3 large-offset-2">* Année de naissance :</label>
                <select id="bornSelect" name="BORN_YEAR" class="large-4">
                    $bornOpt
                </select>
            
            <fieldset class="cell">
                <legend>* Sexe :</legend>
                <div>
                <label for="maleRad">male :</label>
                    <input id="maleRad" type="radio" name="SEXE" value="M" required />
                </div>
                <div>
                <label for="femaleRad">Femelle :</label>
                    <input id="femaleRad" type="radio" name="SEXE" value="F" />
                </div>
                <div>
                <label for="unknownRad">Inconnu :</label>
                    <input id="unknownRad" type="radio" name="SEXE" value="0" checked />
                </div>
            </fieldset>
            
            <label for="specieInp" class="large-3 large-offset-2">* Espèce :</label>
                <input id="specieInp" class="large-4" type="text" name="SPECIE" required />
            
            <label for="descriptionArea" class="large-3 large-offset-2">Motif du rendez-vous :</label>
                <textarea id="descriptionArea" class="cell" name="MOTIF"></textarea>
            
            <input class="large-2 large-offset-2" type="reset" value="Annuler" />
            <input class="large-2 large-offset-4" type="submit" value="Envoyer" />
        </fieldset>
    </form>
</article>
HERE;
    }
        
    /**
     * Construit la liste des messages non répondu
     * 
     * @param array $_data
     * @return string
     */
    public function newMailList($_data, $_print = false) {
        $li = '';
        $descrPreview = '';
        
        foreach ($_data as $newMail) {
            $dateFormat = timeToStringFormat($newMail['time_req'], true);
            $descrPreview = strip_tags(substr($newMail['comment'], 0, 200));
            
            switch ($newMail['status']) {
                case NEW_MESSAGE :      $liClass = 'class="new-message"';       break;
                case ARCHIVE_MESSAGE :  $liClass = 'class="archive-message"';   break;
                default: $liClass = null;
            }
            
            $href = '../php/index.php?EX=userSpace&USER_SPACE=appointment&APPOINTMENT=newReqList&ID='. $newMail['id_req'];
            $li .= '<li '. $liClass .'><a class="jaj" href="'. $href .'" title="Lire le rendez-vous" data-id="'. $newMail['id_req'] .'" data-control="readRequest">'. $dateFormat .' - '. $newMail['firstname'] .' '. $newMail['name'] .'</a><span>'. $newMail['specie'] .' - '. $newMail['pet_name'] .' - '. $newMail['age'] .'ans</span><q>'. $descrPreview .'...</q></li>';
            
        }
        if ($_print) {
            echo $li;
        } else {
            return $li;
        }
    }
    
    
    /**
     * Construit la listses des messages envoyés
     * 
     * @param array $_data
     * @return string
     */
    public function sentMailList($_data, $_print = false) {
        $li = '';
        $descrPreview = '';
        
        foreach ($_data as $sentMail) {
            $dateFormat = timeToStringFormat($sentMail['appointment_date'], true);
            $pdfSize = round((filesize(UP_PDF . $sentMail['pdf'])) / 1024, 2);
            
            $href = '../php/index.php?EX=userSpace&USER_SPACE=appointment&APPOINTMENT=sentReqList&ID='. $sentMail['id_answer'];
            $li .= '<li><a class="jaj" href="'. $href .'" title="Lire le rendez-vous" data-id="'. $sentMail['id_answer'] .'" data-control="readAnswer">'. $dateFormat .' - '. $sentMail['firstname'] .' '. $sentMail['name'] .'</a><span>'. $sentMail['specie'] .' - '. $sentMail['pet_name'] .' - '. $sentMail['age'] .'ans</span><a href="../upload/pdf/'. $sentMail['pdf'].'" target="_blank" class="pdf-link" title="version pdf"><img src="../img/pdf-icon.png" alt="version pdf" />version pdf ('. $pdfSize .' Ko)</a></li>';
            
        }
        
        if ($_print) {
            echo $li;
        } else {
            return $li;
        }
    }
    
    /**
     * Affiche la liste des rendez-vous reçu ou envoyé
     * @param array $_data
     */
    public function showMailBox($_data) {
//         var_dump($_data);
        
        if ($_SESSION['box_type'] == 'newList') {
            $li = $this->newMailList($_data);
            $listTitle = 'Rendez-vous demander';
            $readerTitle = 'Demande de rendez-vous :';
        } elseif ($_SESSION['box_type'] == 'sentList') {
            $li = $this->sentMailList($_data);
            $listTitle = 'Rendez-vous envoyé(s)';
            $readerTitle = 'Détail du rendez-vous :';
        }
        
        
        echo <<<HERE
<article id="grid-x-one" class="grid-y grid-margin-y" aria-label="rendez-vous">
    <nav class="cell ariane">
        <ul class="breadcrumbs">
            <li><a href="../php/">Accueil</a></li>
            <li>Espace employé</li>
            <li><span class="show-for-sr">Current: </span>Rendez-vous</li>
        </ul>
    </nav>
    
    <div class="cell large-10 grid-x grid-margin-x large-margin-collapse medium-margin-collapse small-margin-collapse app-box">
        <nav id="appBox-menu" class="cell large-2 medium-2 small-4" data-sticky-container>
            <div class="sticky" data-sticky data-anchor="appBox-menu">
                <h2 class="appBox-menu-header">Menu</h2>
                <ul id="appBox-vertical-menu" class="">
                    <li id="newMail" class="current">
                        <a href="../php/index.php?EX=userSpace&USER_SPACE=appointment">Reçu</a>
                        <span id="mail-counter" title="{$_SESSION['new_mail_count']} nouveaux message">{$_SESSION['new_mail_count']}</span>
                    </li>
                    <li><a href="../php/index.php?EX=userSpace&USER_SPACE=appointment&APPOINTMENT=sentReqList">Envoyés</a></li>
                </ul>
            </div>
        </nav>
        <section id="appBoxMailList" class="cell large-4 medium-4 small-8" data-sticky-container>
            <h2 class="appBox-menu-header bordered">$listTitle</h2>
            <ul id="mailList">
                $li
            </ul>
        </section>
        <section id="appBoxMailReader" class="cell large-auto medium-auto small-12">
            <h2 class="appBox-menu-header">$readerTitle</h2>
        </section>
    </div>
    <section class="tiny reveal" id="appointmentPreview" data-reveal>
        <h2 class="cell">Confirmation du rendez-vous</h2>
        <section>
            <h3>Récapitulatif</h3>
            <p>
                <span>Rendez-vous donner à : <strong class="data"></strong>.</span>
                <span>Pour le <strong class="data"></strong>.</span>
                <span><strong class="data"></strong></span>
                <span>avec le <strong class="data"></strong>.</span>
            </p>
            <h4>Informations complémentaires</h4>
            <p class="data">
                sieurs variations de Lorem Ipsum peuvent être trouvées ici ou là, mais la majeure partie d'entre elles a été altérée par l'addition d'humour ou de mots aléatoires qui ne ressemblent pas une seconde à du texte standard.
            </p>
        </section>
        <div id="confirmSendMail" class="confirmBTN">
            <button id="abort" class="alert button" data-close type="button">Annuler</button>
            <button id="confirm" class="success button" type="button">Confirmer</button>
        </div>
    </section>
    <aside id="DelRequPopup" class="tiny reveal" aria-label="Suppression de demande de rendez-vous" data-reveal>
        
    </aside>
    <aside id="DelAnswPopup" class="tiny reveal" data-reveal>
    </aside>
</article>
<!-- <script src="../js/app_answer.js"></script> -->
HERE;
    }

    /**
     * Affiche le rendez-vous demandé
     * @param array $_data
     */
    public function showRequest($_data) {
        $mEmploy = new MEmployees();
        $dataDoc = $mEmploy->SelectAllDoctor();
        strip_xss($dataDoc, true);
        
        $label = personLabel($_data['label']);
        
        $date = timeToStringFormat($_data['time_req'], true);
        
        // Contient les options des jours.
        $daysOpts = '<option value="">Jour</option>';
        for ($i = 1; $i <= self::MAX_DAYS; ++$i) {
            $day = ($i < 10) ? '0'.$i : $i;
            $daysOpts .= '<option value="'. $day .'">'. $day .'</option>';
        }
        
        // Contient les options des mois.
        $monthsOpts = '<option value="">Mois</option>';
        foreach (self::MONTHS as $key => $month) {
            $key = ($key < 10) ? '0'. ($key + 1) : ($key + 1);
            $monthsOpts .= '<option value="'. $key .'">'. $month .'</option>';
        }
        
        // contient les options des années.
        
        $currentYear = getdate(time())['year']; // Année en cours.
        $yearsOpts = '<option value="'. $currentYear .'">'. $currentYear .'</option>';
        for ($i = 1; $i <= self::MAX_YEAR_DEPTH; ++$i) {
            $year = $currentYear + $i;
            
            $yearsOpts .= '<option value="'. $year .'">'. $year .'</option>';
        }
        
        // contient les options pour le choix des docteurs.
        $docOptions = '<option value="">Docteurs</option>';
        foreach ($dataDoc as $doc) {
            $docOptions .= '<option value="'. $doc['id'] .'">'. $doc['name'] .' '. $doc['firstname'] .'</option>';
        }
        
        if($_data['phone']) {
            $memberPhone = '<span><abbr title="numéro de téléphone">N° tél</abbr> :'. $_data['phone'];
        } else {
            $memberPhone = '<span><em>Le client n\'a pas renseigné sont <abbr title="numéro">n°</abbr> de téléphone</em></span>';
        }
        
        echo <<<HERE
<h2 class="appBox-menu-header">Demande de rendez-vous :</h2>
<section id="details" aria-label="Coordonnées du client et de son animal">
    <span><strong>$label {$_data['firstname']} {$_data['name']}</strong></span>
    <span>Envoyé <strong>$date</strong>.</span>
    
    <span>Pour le {$_data['specie']} {$_data['pet_name']} de {$_data['age']} ans.</span>
    $memberPhone
</section>
<section>
    <h3>Motif du rendez-vous :</h3>
    {$_data['comment']}
</section>
<form id="appResponce">
    <fieldset>
        <legend class="appBox-menu-header">Répondre</legend>
        <fieldset class="date-form">
            <legend>Date du rendez-vous :</legend>
            <div id="daySlct">
                <label for="dayAppDate">Jour :</label>
                    <select id="dayAppDate" name="DATE_DAY" required>
                        $daysOpts
                    </select>
            </div>
            <div id="monthSlct">
                <label for="monthAppDate">Mois :</label>
                    <select id="monthAppDate" name="DATE_MONTH" required>
                        $monthsOpts
                    </select>
            </div>
            <div id="yearSlct">
                <label for="yearAppDate">Année :</label>
                    <select id="yearAppDate" name="DATE_YEAR" required>
                        $yearsOpts
                    </select>
            </div>
            <div id="date-form-hour">
                <div>
                    <label for="hourAppTime">Heure :</label>
                        <input id="hourAppTime" type="number" min="0" max="24" step="1" name="TIME_H" required />
                </div>
                <div>
                    <label for="minAppTime">Minute :</label>
                        <input id="minAppTime" type="number" min="0" max="60" step="5" name="TIME_MIN" required />
                </div>   
            </div>
        </fieldset>
            <label for="docForApp">Docteur :</label>
        <select id="docForApp" name="DOCTOR" required>
            $docOptions
        </select>

        <label for="descriptionArea">Informations complémentaire :</label>
            <textarea id="descriptionArea" name="DOCTOR_REQU"></textarea>

        <input type="reset" value="Annuler" />
        <input type="submit" value="Envoyer le rendez-vous" />
        <button id="dataOpen" aria-hidden="true" data-open="appointmentPreview">confirm</button>

    </fieldset>
</form>
<!-- <a id="deleteMail" class="button alert" href="../php/index.php?EX=userSpace&USER_SPACE=appointment&APPOINTMENT=requestDelete&ID={$_data['id_req']}" title="Suppression définitive" data-id="{$_data['id_req']}" data-control="AJAX_deleteRequest">Supprimer</a> -->
<button id="openDelPopup" class="button alert" data-open="DelRequPopup" data-ident="{$_data['id_req']}" data-control="AJAX_delReqPopup">Supprimer</button>
HERE;
    }
    
    
    public function showAnswer($_data) {
        $clientLabel = personLabel($_data['label']);
        $reqDate = timeToStringFormat($_data['time_req']);
        $clientComment = ($_data['comment'] != null) ? $_data['comment'] : '<p><em>Pas de commentaires ajouter de la part du client</em></p>';
        
        $docDate = timeToStringFormat($_data['appointment_date']);
        $docComment= ($_data['vet_comment'] != null) ? $_data['vet_comment'] : '<p><em>Pas de commentaires ajouter de la part du docteur</em></p>';
        
        $pdfSize = round((filesize(UP_PDF . $_data['pdf'])) / 1024, 2);
        
        if($_data['phone']) {
            $memberPhone = '<span><abbr title="numéro de téléphone">N° tél</abbr> :'. $_data['phone'];
        } else {
            $memberPhone = '<span><em>Le client n\'a pas renseigné sont <abbr title="numéro">n°</abbr> de téléphone</em></span>';
        }
        
        echo <<<HERE
        <h2 class="appBox-menu-header">Détail du rendez-vous :</h2>
<div id="answer">
    <section>
        <h3>Rendez-vous demander par :</h3>
        <p>
            <span>$clientLabel {$_data[16]} {$_data[17]},</span>
            <span>$reqDate.</span>
            <span>Pour le {$_data['specie']} {$_data['pet_name']} de {$_data['age']} ans</span>
            $memberPhone
        </p>    
        <h4>Commentaire du client :</h4>
        $clientComment
    </section>
    <section>
        <h3>Rendez-vous pris par :</h3>
        <p>
            <span>Le docteur {$_data['firstname']} {$_data['name']}</span>
            <span>à la date du $docDate</span>
        </p>
        <h4>Commentaire du docteur :</h4>
        $docComment
    </section>
    <div>
        <a href="../upload/pdf/{$_data['pdf']}" target="_blank" class="pdf-link" title="version pdf"><img src="../img/pdf-icon.png" alt="version pdf" />version pdf ($pdfSize Ko)</a>
        <!-- <a id="deleteMail" href="../php/index.php?EX=userSpace&USER_SPACE=appointment&APPOINTMENT=deleteAnswer&ID={$_data['id_answer']}" class="alert button" title="Suppression définitive" data-id="{$_data['id_answer']}" data-control="AJAX_deleteAnswer">Supprimer</a> -->
        <button id="openDelPopup" class="alert button" data-open="DelAnswPopup" data-ident="{$_data['id_answer']}" data-control="AJAX_delAnswPopup">Supprimer</button>
    </div>
</div>
HERE;
    }
        
    public function showdelReqPopup($_data) {
//         var_dump($_data);
        
        $label = personLabel($_data['label']);
        $date = timeToStringFormat($_data['time_req'], true);
        
        echo <<<HERE
<div class="reveal-content">
    <p>
        <img src="../img/warning.png" alt="Attention !" />
        <span>Etes-vous sur de vouloir <strong>supprimer</strong> la demande de rendez vous de :</span>
        <span><strong>$label {$_data['firstname']} {$_data['name']}</strong></span>
        <span>Envoyé <strong>le $date</strong>.</span>
        <span>Pour le <strong>{$_data['specie']} {$_data['pet_name']} de {$_data['age']}</strong> ans.</span>
    </p>
</div>
<div class="confirmBTN">
    <button class="button alert" data-close>Non</button>
    <button id="deleteMail" class="button success" data-close title="Suppression définitive" data-control="AJAX_deleteRequest" data-ident="{$_data['id_req']}">Oui</button>
</div>
HERE;
    }
        
    public function showdelAnswPopup($_data) {
//                 var_dump($_data);
        
        $label = personLabel($_data['label']);
        $date = timeToStringFormat($_data['time_req'], true);
        
        echo <<<HERE
<div class="reveal-content">
    <p>
        <img src="../img/warning.png" alt="Attention !" />
        <span>Etes-vous sur de vouloir <strong>supprimer</strong> le rendez-vous donné à :</span>
        <span><strong>$label {$_data['firstname']} {$_data['name']}</strong></span>
        <span>Envoyé <strong>le $date</strong>.</span>
        <span>Pour le <strong>{$_data['specie']} {$_data['pet_name']} de {$_data['age']}</strong> ans.</span>
    </p>
</div>
<div class="confirmBTN">
    <button class="button alert" data-close>Non</button>
    <button id="deleteMail" class="button success" data-close title="Suppression définitive" data-control="AJAX_deleteAnswer" data-ident="{$_data['id_answer']}">Oui</button>
</div>
HERE;
    }
    
    public function showPreviewJSON($_data) {
        
        $time = timeToStringFormat(mktime($_data['post']['TIME_H'], $_data['post']['TIME_MIN'], 0, $_data['post']['DATE_MONTH'], $_data['post']['DATE_DAY'], $_data['post']['DATE_YEAR']), true);
        $_data['post']['date'] = $time;
        
        echo json_encode($_data);
    }
    
    public function showData($_data) {
        echo $_data;
    }
    
    
}