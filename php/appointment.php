<?php
// Variable de controle de APPOINTMENT
$APPOINTMENT = (isset($_REQUEST['APPOINTMENT'])) ? $_REQUEST['APPOINTMENT'] : null;


switch ($APPOINTMENT) {
    // request (demande de RDV).
    case 'requestForm':         requestForm();          break;
    case 'requestInsert':       requestInsert();        break;
    case 'requestDelete':       requestDelete();        break;
    case 'newReqList':          newReqList();           break;
    
    
    // request AJAX (demande de RDV).
    case 'readRequest':         readRequest();          exit();
    case 'AJAX_deleteRequest':  AJAX_deleteRequest();   exit();
    case 'AJAX_newReqCounter':  AJAX_newReqCounter();   exit();
    case 'AJAX_delReqPopup':    AJAX_delReqPopup();     exit();
    
    // answer (renponce de RDV).
    case 'sentReqList':         sentReqList();          break;
    case 'deleteAnswer':        deleteAnswer();         break;
    case 'AJAX_delAnswPopup':   AJAX_delAnswPopup();      exit();
    
    // answer AJAX (renponce de RDV).
    case 'readAnswer':          readAnswer();           exit();   
    case 'AJAX_deleteAnswer':   AJAX_deleteAnswer();    exit();
    
    // données formatées en JSON pour la prévisualisation.
    case 'dataPreview':         dataPreview();          exit();
    
    // Envoie de l'email.
    case 'sendEmail':           sendEmail();            exit();
    
    // Ouverture de la boite de messagerie (rendez-vous).
    default: app_box();
}

function app_box() {
    if ($_SESSION['MEMBER']['status'] <= EMPLOYEE_STAT) {
        newReqList();
    } else {
        requestForm();
    }
}

// Affichage du formulaire pour la prise d'un rendez-vous.
function requestForm() {
    VerifMember();
    
    global $content;
    
    $content['title'] = 'Demande de rendez-vous | CAT CLINIC';
    $content['class'] = 'VAppointment';
    $content['meth'] = 'showRequestForm';
    $content['arg'] = '';
}


// Nouvelle demande de rendez-vous.
// Insertion d'un nouveau message dans la table request.
function requestInsert() {
    VerifMember();
    
    $mRequest = new MRequest();
    $mRequest->setValue($_POST);
    $mRequest->modify('Insert');
    
    header('location: ../php/');
}

// Suppression de la demande de rendez-vous
function requestDelete() {
    VerifEmploy();
    
    $mRequest = new MRequest($_GET['ID']);
    $mRequest->modify('Delete');
    
    header('location: ../php/index.php?EX=userSpace&USER_SPACE=appointment');
}

// Suppression de la demande de rendez-vous (AJAX)
function AJAX_deleteRequest() {
    VerifEmploy();
    
    $mRequest = new MRequest($_GET['ID']);
    $mRequest->modify('Delete');
    
    
    AJAX_newReqList();
}



// Affichage de la liste rendez-vous nouveau
// ou lut mais sans réponse.
function newReqList() {
    VerifEmploy();
    
    $mRequest = new MRequest();
    $data = $mRequest->SelectAll();
    strip_xss($data, true);
    
    $_SESSION['box_type'] = 'newList';
    $_SESSION['new_mail_count'] = MRequest::counterStatus(NEW_MESSAGE)['COUNT(*)'];
    
    global $content;
    
    $content['title'] = 'L\'équipe | CAT CLINIC';
    $content['class'] = 'VAppointment';
    $content['meth'] = 'showMailBox';
    $content['arg'] = $data;
}

// Affichage de la liste des rendez-vous envoyés
function sentReqList() {
    VerifEmploy();
    
    $mAnswer = new MAnswer();
    $data = $mAnswer->SelectAll();
    strip_xss($data);
    
    $_SESSION['box_type'] = 'sentList';
    $_SESSION['new_mail_count'] = MRequest::counterStatus(NEW_MESSAGE)['COUNT(*)'];
    
    
    global $content;
    
    $content['title'] = 'L\'équipe | CAT CLINIC';
    $content['class'] = 'VAppointment';
    $content['meth'] = 'showMailBox';
    $content['arg'] = $data;
}

// Affichage du code HTML du rendez-vous
// utilisé par javascript.
function readRequest() {
    VerifEmploy();
    
    $mRequest = new MRequest($_GET['ID']);
    $data = $mRequest->Select();
    strip_xss($data, true);
    
    $_SESSION['CURRENT_MAIL'] = $data;
    
    $vAppointment = new VAppointment();
    $vAppointment->showRequest($data);
    
    if ($data['status'] == NEW_MESSAGE) {
        $mRequest->UpdateStatus(ARCHIVE_MESSAGE);
    }
    
}

// Génération du code html permettant de lire 
// le rendez-vous pris
function readAnswer() {
    VerifEmploy();
    
    $mAnswer = new MAnswer($_GET['ID']);
    $data = $mAnswer->Select();
    strip_xss($data);
    
    $vApp = new VAppointment();
    $vApp->showAnswer($data);
}

// Suppression du rendez-vous
function deleteAnswer() {
    VerifEmploy();
    
    $mAnswer = new MAnswer($_GET['ID']);
    $mAnswer->modify('Delete');
    
    header('location: ../php/index.php?EX=userSpace&USER_SPACE=appointment&APPOINTMENT=sentReqList');
}

function AJAX_delAnswPopup() {
    $mAnswer = new MAnswer($_POST['ID']);
    $data = $mAnswer->Select();
    strip_xss($data);
    
    $vApp = new VAppointment();
    $vApp->showdelAnswPopup($data);
}

function AJAX_deleteAnswer() {
    VerifEmploy();
    
    $mAnswer = new MAnswer($_GET['ID']);
    $mAnswer->modify('Delete');
    
    $data = $mAnswer->SelectAll();
    strip_xss($data, true);
    
    $vApp = new VAppointment();
    $vApp->sentMailList($data, true);
}


// Envoie des données sous forme JSON pour 
// la prévisualisation du rendez-vous.
function dataPreview() {
    VerifEmploy();
    
    $mEmploy = new MEmployees($_POST['DOCTOR']);
    $data = $mEmploy->Select();
    
    $dataPreview = array(
        'post'              =>      $_POST,
        'current_mail'      =>      $_SESSION['CURRENT_MAIL']
    );
    
    $dataPreview['post']['DOCTOR'] = array(
        'id'        =>      $data['id'],
        'firstname' =>      $data['firstname'],
        'name'      =>      $data['name']
    );
    
    $vApp = new VAppointment();
    $vApp->showPreviewJSON($dataPreview);
    
    $_SESSION['FORM_DATA'] = $dataPreview;
}

// Génération du pdf à envoyer au client
// Envoie de l'email
// Si l'email a bien été envoyer, 
// insertion de la réponce dans la table answer. 
function sendEmail() {
    VerifEmploy();
    
    $pathFile = uploadAppPdf();
    
    $cMail = new CMail();
    $cMail->setMessageAppointment($_SESSION['FORM_DATA']);
    $cMail->setSujet('CAT CLINIC Rendez-vous vétérinaire : convocation');
    $cMail->setMail($_SESSION['FORM_DATA']['current_mail']['email']);
    
    preg_match('/appointment-[0-9]*.pdf/', $pathFile, $pdfName);
    
    $_SESSION['FORM_DATA']['current_mail']['pdf'] = $pdfName[0];
    
    $test = $cMail->mailTo($pathFile);
    if ($test) {
        insertAnswer();
        AJAX_newReqList();
    } else {
        echo $test;
    }
    
    unset($_SESSION['FORM_DATA']);
}

// Génération du code html de la liste des nouveau message
// utilisé par javascript (AJAX)
function AJAX_newReqList() {
    VerifEmploy();
    
    $mRequest = new MRequest();
    $data = $mRequest->SelectAll();
    strip_xss($data, true);
    
    $vApp = new VAppointment();
    $vApp->newMailList($data, true);
}


/**
 * Rénération du fichier pdf.
 * Stockage de celui-ci dans ../upload/pdf
 * 
 * @return string chemin absolut vers le fichier *.pdf
 */
function uploadAppPdf() {
    VerifEmploy();
    
    $mDetails = new MDetails();
    $detailsData = $mDetails->Select();
    strip_xss($detailsData);
    
    $data = array(
        'details'   =>      $detailsData,
        'form_data' =>      $_SESSION['FORM_DATA']
    );
    
    $pathFile = UP_PDF .'appointment-'. time() .'.pdf';
    
    $pdf = new CPdf();
    $pdf->pdfForAppointment($data);
    $pdf->setOuputPath($pathFile);
    $pdf->pdfGeneration();
    
    return $pathFile;
}

/**
 * Insertion du rendez-vous dans la table answer.
 * Mise à jour du status de ce rendez-vous. (message envoyé)
 */
function insertAnswer() {
    VerifEmploy();
    
    $mAnswer = new MAnswer();
    $mAnswer->setValue($_SESSION['FORM_DATA']);
    $mAnswer->modify('Insert');
}

// Compte le nombre de nouveaux rendez-vous (non lus).
function AJAX_newReqCounter() {
    VerifEmploy();
    
    $mReq = new MRequest();
    $data = $mReq->counterStatus(NEW_MESSAGE);
    
    $vApp = new VAppointment();
    $vApp->showData($data['COUNT(*)']);
}

function AJAX_delReqPopup() {
    $mRequest = new MRequest($_POST['ID']);
    $data = $mRequest->Select();
    strip_xss($data);
    
    $vApp = new VAppointment();
    $vApp->showdelReqPopup($data);
}
