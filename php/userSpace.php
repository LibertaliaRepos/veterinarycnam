<?php
// Variable de controle de userSpace.
$USER_SPACE = isset($_REQUEST['USER_SPACE']) ? $_REQUEST['USER_SPACE'] : null;

// var_dump($_SESSION);

switch ($USER_SPACE) {
    // 1) inscription, connection et gestion des membres.
    case 'inscription':         inscription();      break;
    case 'updateMemberForm':    updateMemberForm(); break;
    case 'updateMember':        updateMember();     break;
    case 'unsubscribe':         unsubscribe();      break;
    
    case 'verifUser':           verifUser();        break;
    case 'disconnect':          disconnect();       break;
    
    case 'AJAX_checkMail':      AJAX_checkMail();   exit();
    
    // 2) coordonnées de la clinique.
    case 'detailsModif':    detailsModif();     break;
    case 'updateDetails':   updateDetails();    break;
    
    // 3) horaires d'ouverture.
    case 'schedulesInsert':  schedulesInsert(); break;
    case 'schedulesModif':   schedulesModif();  break;
    
    // 4) Gestion des employés
    case 'employeesModif':   employeesModif();  break;
    case 'employeesInsert':  employeesInsert(); break;
    case 'employeesUpdate':  employeesUpdate(); break;
    case 'employeesDelete':  employeesDelete(); break;
    
    case 'appointment':      appointment();     break;
    
    default:    logAndConnection();
}

// 1) ---------------------------------inscription et connection-------------------------------
/**
 * Affiche la page pemerttant de se connecter
 * ou de s'inscrire
 */
function logAndConnection() {
    
    global $content;
    
    $content['title'] = 'Espace client | CAT CLINIC';
    $content['class'] = 'VHTML';
    $content['meth'] = 'showHTML';
    $content['arg'] = 'userSpace';
}// logAndConnection()

/**
 * Vérifie :
 * Que les deux mails sont identiques,
 * Que les deux mots de passe sont identiques,
 * 
 * puis insertion du membre dans la base de donnée
 * 
 * futur: affichage d'un message d'erreur si une infomation est fausse.
 */
function inscription() {
     
    $data = null;
    
    // Vérification des emails:
    // les deux emails doivent être identiques.
    if (isset($_POST['EMAIL1']) && isset($_POST['EMAIL2'])) {
        if ($_POST['EMAIL1'] === $_POST['EMAIL2']) {
            $data['EMAIL'] = $_POST['EMAIL1'];
        }
    }
    
    // Vérification des mots de passe:
    // les deux mots de passe doivent être identiques.
    if (isset($_POST['PWD1']) && isset($_POST['PWD2'])) {
        if ($_POST['PWD1'] === $_POST['PWD2']) {
            $data['PWD'] = $_POST['PWD1'];
        }
    }
    
    
    // Insertion du member dans la table member
    if(count($data) == 2) {
        $data['LABEL'] = $_POST['LABEL'];
        $data['FIRSTNAME'] = $_POST['FIRSTNAME'];
        $data['NAME'] = $_POST['NAME'];
        
        $mMember = new MMember();
        $mMember->setValue($data);
//         $lastID = $mMember->modify('Insert');
        
//         $_SESSION['inscription'] = $mMember->Select($lastID);
        
        $_SESSION['inscription'] = $mMember->modify('Insert');
        
//         var_dump($lastID);
//         var_dump($_SESSION);
    }
    
//     exit();
    inscrEmail();
    
    header('location: ../php/');        
    return;
}// inscription()

function updateMemberForm() {
    VerifMember();
    
    global $content;
    
    $content['title'] = 'Espace client | CAT CLINIC';
    $content['class'] = 'VMember';
    $content['meth'] = 'showUpdateForm';
    $content['arg'] = '';
}

function updateMember() {
    VerifMember();
    
    $data = null;
    
    // Test si l'utilisateur veut changer son adresse de messagerie.
    if ($_POST['OLD_MAIL'] != '' && $_POST['NEW_MAIL1'] != '' && $_POST['NEW_MAIL2'] != '') {
        // Vérification que l'ancienne adresse est bien le bon.
        // Vérification que la nouvelle adresse et sa confirmation sont bien identiques.
        if ($_POST['OLD_MAIL'] == $_SESSION['MEMBER']['email'] && $_POST['NEW_MAIL1'] == $_POST['NEW_MAIL2']) {
            $data['EMAIL'] = $_POST['NEW_MAIL1'];
        } else {
            $data['EMAIL'] = null;
        }
    } else {
        $data['EMAIL'] = null;
    }
    
    // Test si l'utilisateur veut changer son mot de passe.
    if ($_POST['OLD_PWD'] != '' && $_POST['NEW_PWD1'] != '' && $_POST['NEW_PWD2'] != '') {
        // Vérification que l'ancien mots de passe est bien le bon.
        // Vérification que le mot de passe et sa confirmation ont bien identique.
        if ($_POST['OLD_PWD'] == $_SESSION['MEMBER']['password'] && $_POST['NEW_PWD1'] == $_POST['NEW_PWD2']) {
            $data['PWD'] = $_POST['NEW_PWD1'];
        } else {
            $data['PWD'] = null;
        }
    } else {
        $data['PWD'] = null;
    }
    
    $data['PHONE'] = $_POST['MEM_PHONE'];
    
    $mMember = new MMember($_SESSION['MEMBER']['id']);
    $mMember->setValue($data);
    $_SESSION['inscription'] = $mMember->modify('Update');
    
    $_SESSION['MEMBER'] = $_SESSION['inscription'];
    
    inscrEmail();
    header('location: ../php/index.php?EX=userSpace&USER_SPACE=updateMemberForm');
}

function inscrEmail() {
    
    $cMail = new CMail();
    $cMail->setMail($_SESSION['inscription']['email']);
    $cMail->setSujet('CAT CLINIC: identifiant de connection');
    $cMail->setInscrEmail($_SESSION['inscription']);
    
    $test = $cMail->mailTo();
    
//     var_dump($test);
//     var_dump($_SESSION['inscription']);
    
//     exit();
    
    unset($_SESSION['inscription']);
}

function unsubscribe() {
    VerifMember();
    
    $mMember = new MMember($_SESSION['MEMBER']['id']);
    $mMember->modify('Delete');
    
    disconnect();
    
    header('location: ../php/');
}

/**
 * Vérifie que le membre est bien inscrit.
 * S'il est inscrit, 
 * 
 * insertion dans la variable global 
 * $_SESSION['MEMBER'] des doinnées de celui-ci
 */
function verifUser() {
    $mMember = new MMember();
    $data = $mMember->verifUser($_GET);
    strip_xss($data);
    
    
    if ($data) {
        $_SESSION['MEMBER'] = $data;
    }
    
    header('location: ../php/');
}// verifUser()

function AJAX_checkMail() {
    $mMember = new MMember();
    $data = $mMember->verifMail($_POST['EMAIL']);
    
    
    VAjax::showData($data);
}// verifUser()


/**
 * Déconnection du membre,
 * suppression de la variable $_SESSION['MEMBER']
 * puis redicection vers l'accueil du site.
 */
function disconnect() {
    unset($_SESSION['MEMBER']);
    header('location: ../php/');
}// disconnect()

// 2) --------------------------------coordonnées de la clinique-------------------------------------------

/**
 * Affichage du formulaire de modification
 * des informations sur les coordonnées de la clinique.
 */
function detailsModif() {
    VerifAdmin();
    
    $mDetails = new MDetails();
    $data = $mDetails->Select();
    strip_xss($data);
    
    global $content;
    
    $content['title'] = 'Modif Coord... | CAT CLINIC';
    $content['class'] = 'VDetails';
    $content['meth'] = 'showDetailsForm';
    $content['arg'] = $data;
}// detailsModif()

/**
 * Mise à jour des données relative aux coordonnées du site
 * dans la base de données
 */
function updateDetails() {
    VerifAdmin();
    
    $_POST['PHOTO'] = uploadPhoto('PHOTO', UP_ACCUEIL);
    
    $mDetails = new MDetails();
    $mDetails->setValue($_POST);
    $mDetails->modify('Update');
    
    header('location: ../php/index.php?EX=userSpace&USER_SPACE=detailsModif');
}// updateDetails()


// 3) ----------------------------------horaires d'ouverture-----------------------------------------------

function schedulesInsert() {
    VerifAdmin();
    
    $mSchedules = new MSchedules();
    $mSchedules->setValue($_POST);
    $mSchedules->modify('Insert');
}

/**
 * Affichage du formulaire de modification
 * des horaires d'ouvertures de la clinique.
 */
function schedulesModif() {
    VerifAdmin();
    
    $mSchedules = new MSchedules();
    $data = $mSchedules->selectAll();
    strip_xss($data);
    
    global $content;
    
    $content['title'] = 'Modif horaires... | CAT CLINIC';
    $content['class'] = 'VSchedules';
    $content['meth'] = 'showForm';
    $content['arg'] = $data;
}// schedulesModif()

// 4) -----------------------------------Gestion des employés et de leurs droit sur le site-----------------

/**
 * Affichage des employé
 * avec un formulaire permettant d'ajouter un employé.
 */
function employeesModif() {
    VerifAdmin();
    
    $mEmployees = new MEmployees();
    $data = $mEmployees->SelectAll();
    strip_xss($data, true);
    
    $data['idModification'] = (isset($_GET['ID'])) ? $_GET['ID'] : null;
    
    global $content;
    
    $content['title'] = 'Gestion employés | CAT CLINIC';
    $content['class'] = 'VEmployees';
    $content['meth'] = 'showEmployeesModifPage';
    $content['arg'] = $data;
}

function employeesInsert() {
    VerifAdmin();
    
    $_POST['PHOTO'] = uploadPhoto('PHOTO', UP_EMPLOYEES);
    
    $mEmployees = new MEmployees();
    $mEmployees->setValue($_POST);
    $mEmployees->modify('Insert');
}

function employeesUpdate() {
    VerifAdmin();
    
    $_POST['PHOTO'] = uploadPhoto('PHOTO', UP_EMPLOYEES);
    
    $mEmployees = new MEmployees($_GET['ID']);
    $mEmployees->setValue($_POST);
    $mEmployees->modify('Update');
    
    header('location: ../php/index.php?EX=employees');
}

function employeesDelete() {
    VerifAdmin();
    
    $mEmployees = new MEmployees($_GET['ID']);
    $mEmployees->modify('Delete');
}

function appointment() {
    VerifMember();
    
    require('../php/appointment.php');
}



