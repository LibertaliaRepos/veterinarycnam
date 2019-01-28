<?php
session_start();
session_name('VETERINARY');
require('../inc/require.inc.php');

// var_dump($_SESSION['MEMBER']);

// controler principal
$EX = isset($_REQUEST['EX']) ? $_REQUEST['EX'] : 'home';

switch ($EX) {
    case 'home':            home();             break;
    case 'employees':       employeesPage();    break;
    case 'advices':         advicesPage();      break;
    case 'vaccin':          vaccinPage();       break;
    case 'homeDanger':      homeDangerPage();   break;
    case 'medication':      medicationPage();   break;
    case 'userSpace':       userSpacePage();    break;
    case 'contact':         contactPage();      break;
    case 'siteMap':         siteMapPage();      break;
    
    case 'AJAX_valideMail':         AJAX_valideMail();      exit();
    case 'AJAX_mapData':            AJAX_mapData();         exit();
    case 'AJAX_forgotPass':         AJAX_forgotPass();      exit();
    case 'AJAX_requestPassword':    AJAX_requestPassword(); exit();
    case 'AJAX_passSent':           AJAX_passSent();        exit();
}

require('../view/layout.view.php');



function home() {
    $mdetails = new MDetails();
    $data['details'] = $mdetails->Select();
    $mSchedules = new MSchedules();
    $data['schedules'] = $mSchedules->selectAll();
    $mEmployees = new MEmployees();
    $data['doctors'] = $mEmployees->SelectAllDoctor();
    
    global $content;
    
    $content['title'] = 'Accueil | CAT CLINIC';
    $content['class'] = 'VAccueil';
    $content['meth'] = 'showAccueil';
    $content['arg'] = $data;
}

function employeesPage() {
    $mEmployees = new MEmployees();
    $data = $mEmployees->SelectAll();
    strip_xss($data, true);
    
    global $content;
    
    $content['title'] = 'L\'équipe | CAT CLINIC';
    $content['class'] = 'VEmployees';
    $content['meth'] = 'showEmployeesPage';
    $content['arg'] = $data;
}

function advicesPage() {
    
    global $content;
    
    $content['title'] = 'Conseil | CAT CLINIC';
    $content['class'] = 'VHTML';
    $content['meth'] = 'showHTML';
    $content['arg'] = 'advices';
}

function vaccinPage() {
    
    global $content;
    
    $content['title'] = 'Maladie et vaccination | CAT CLINIC';
    $content['class'] = 'VHTML';
    $content['meth'] = 'showHTML';
    $content['arg'] = 'vaccin';
}

function homeDangerPage() {
    
    global $content;
    
    $content['title'] = 'Maladie et vaccination | CAT CLINIC';
    $content['class'] = 'VHTML';
    $content['meth'] = 'showHTML';
    $content['arg'] = 'homeDanger';
}

function medicationPage() {
    
    global $content;
    
    $content['title'] = 'Administration des médicaments | CAT CLINIC';
    $content['class'] = 'VHTML';
    $content['meth'] = 'showHTML';
    $content['arg'] = 'medication';
}

function userSpacePage() {
    require('../php/userSpace.php');
}

function AJAX_valideMail() {
    VAjax::showData(emailValidation($_POST['EMAIL']));
}

function contactPage() {
    $mdetails = new MDetails();
    $data['details'] = $mdetails->Select();
    $mSchedules = new MSchedules();
    $data['schedules'] = $mSchedules->selectAll();
    $mEmployees = new MEmployees();
    $data['doctors'] = $mEmployees->SelectAllDoctor();
    
    global $content;
    
    $content['title'] = 'Accueil | CAT CLINIC';
    $content['class'] = 'VContact';
    $content['meth'] = 'showContact';
    $content['arg'] = $data;
}

function siteMapPage() {
    global $content;
    
    $content['title'] = 'Accueil | CAT CLINIC';
    $content['class'] = 'VHTML';
    $content['meth'] = 'showHTML';
    $content['arg'] = 'siteMap';
}

function AJAX_mapData() {
    $mDetails = new MDetails();
    VAjax::showData($mDetails->mapData());
}

function AJAX_forgotPass() {
    $vMember = new VMember();
    $vMember->showForgotPassForm();
}

function AJAX_requestPassword() {
    if(strlen($_POST['FORGOT_EMAIL']) > 0 && emailValidation($_POST['FORGOT_EMAIL']) && $_POST['NOT_ROBOT'] == 'on') {
        $mMember = new MMember();
        $mMember->setValue($_POST['FORGOT_EMAIL']);
        $data = $mMember->SelectByMail();
        strip_xss($data);
        
        
        if ($data) {
            $cMail = new CMail();
            $cMail->setMail($data['email']);
            $cMail->setSujet('CAT CLINIC : rappel de vos identifiants.');
            $cMail->setInscrEmail($data);
            
            $cMail->mailTo();
        }
    }
    VAjax::showData($_POST);
}

function AJAX_passSent() {
    $vMember = new VMember();
    $vMember->showPassSent();
}
