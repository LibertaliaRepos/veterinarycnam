<?php
use PHPMailer\PHPMailer\PHPMailer;

class CMail {
    
	private $message;
	private $sujet;
	private $mail;
	private $mailer;
	private $mailFooter;
	
	public function __construct(){
	    $this->mailer = new PHPMailer();
	    $this->setMailFooter();
	    
	}
	
	public function __destruct(){}
	
	public function setMail($_mail) {
		$this->mail = $_mail;
	}
	
	public function setMessage($_txt) {
		$this->message = $_txt;
	}
	
	public function setSujet($_sujet) {
		$this->sujet = $_sujet;
	}
	
	public function mailTo($_joinFilePath = null) {
        $this->mailer->setFrom('libertalia@franceserv.com', 'CAT CLINIC');
        $this->mailer->addReplyTo('noreply@franceserv.com', '<noreply@franceserv.com>');
        $this->mailer->addAddress($this->mail);
        $this->mailer->msgHTML($this->message, __DIR__);
        $this->mailer->Subject = $this->sujet;
        
        if ($_joinFilePath) {
            $this->mailer->addAttachment($_joinFilePath);
        }
        if (!$this->mailer->send()) {
            return 'Mailer Error: '. $this->mailer->ErrorInfo;
        } else {
            return true;
        }
	}
	
	
	
	public function setMessageAppointment($_data) {
	    
	    $label = personLabel($_data['current_mail']['label']);
	    $formtedDate = timeToStringFormat(mktime($_data['post']['TIME_H'], $_data['post']['TIME_MIN'], 0, $_data['post']['DATE_MONTH'], $_data['post']['DATE_DAY'], $_data['post']['DATE_YEAR']), true);
	    
	    $doctor_requ = ($_data['post']['DOCTOR_REQU'] != '') ? $_data['post']['DOCTOR_REQU'] : '<em>Aucune information particulière</em>';
	    
	    $this->message = <<<HERE
<!DOCTYPE html>
<html lang="fr">
    <head></head>
    
    <body style="max-width: 800px;margin: auto;min-width: 566px;overflow-x: scroll">
        <table>
            <tr> <!-- LOGO -->
                <a href="http://testveterinarycnam.franceserv.com/php/" title="vers CAT CLINIC">
                    <td style="text-align: center;"><img style="max-width: 100%;" src="http://testveterinarycnam.franceserv.com/img/catclinic_v2.3.2.png" alt="logo de CAT CLINIC" /></td>
                </a>
            </tr>
        </table>
        <table style="border-collapse: collapse;">
            <thead style="background-color: #cacaca;">
                <tr> <!-- h1 -->
                    <th colspan="{$this->mailFooter['colspan']}" style="padding: 0;"><h1 style="font-size: 1.2em;text-align: center;margin: 0;font-family: Verdana, Arial, Helvetica, sans-serif;font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;width: 100%">Votre rendez-vous</h1></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="{$this->mailFooter['colspan']}" style="padding: 5px 0;"><strong>$label {$_data['current_mail']['firstname']} {$_data['current_mail']['name']}</strong>,</td>
                </tr>
                <tr>
                    <td colspan="{$this->mailFooter['colspan']}" style="padding: 5px 0;">vous nous avez demandé rendez-vous depuis notre site internet pour votre <strong>{$_data['current_mail']['specie']} {$_data['current_mail']['pet_name']}</strong>.</td>
                </tr>
                <tr>
                    <td colspan="{$this->mailFooter['colspan']}" style="padding: 5px 0;">Vous avez rendez-vous avec le <strong>{$_data['post']['DOCTOR']['firstname']} {$_data['post']['DOCTOR']['name']} $formtedDate</strong>.</td>
                </tr>
                <tr style="background-color: #cacaca;">
                    <th colspan="{$this->mailFooter['colspan']}" style="padding: 0;">
                        <h2 style="font-size: 0.9em;margin: 0;font-family: Verdana, Arial, Helvetica, sans-serif;font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;padding-left: 10%;text-align: left;">Commentaire du docteur :</h2>
                    </th>
                </tr>
                <tr style="background-color: #e6e6e6;">
                    <td colspan="{$this->mailFooter['colspan']}" style="padding: 1%;">$doctor_requ</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="{$this->mailFooter['colspan']}" style="padding-top: 5%;">
                        En cas d'<strong>impossibilité</strong> de votre part d'être présent veuillez contacter notre accueil par <strong>téléphone au 98 76 54 32 10</strong><br />
                        Veuillez vous munir:
                    </td>
                </tr>
                <tr>
                    <td colspan="{$this->mailFooter['colspan']}">
                        <ul>
                            <li>de la convocation (piece jointe),</li>
                            <li>du carnet de santé de votre animal.</li>
                        </ul>
                    </td>
                </tr>
            </tfoot>
        </table>
        {$this->mailFooter['content']}
    </body>
</html>
HERE;
	}
                
	public function setInscrEmail($_data) {
	    $mDetails = new MDetails();
	    $detailsData = $mDetails->Select();
	    strip_xss($detailsData);
	    
	    $label = personLabel($_data['label']);
	    
	    
	    $this->message = <<<HERE
<!DOCTYPE html>
<html lang="fr">
    <head></head>
    
    <body style="max-width: 800px;margin: auto;min-width: 566px;overflow-x: scroll">
        <table>
            <thead>
                <tr> <!-- LOGO -->
                    <th style="text-align: center;">
                        <a href="http://testveterinarycnam.franceserv.com/php/" title="vers CAT CLINIC">
                            <img style="max-width: 100%;" src="http://testveterinarycnam.franceserv.com/img/catclinic_v2.3.2.png" alt="logo de CAT CLINIC" />
                        </a>
                    </th>
                </tr>
                <tr style="background-color: #cacaca;"> <!-- h1 -->
                    <th  style="padding: 0;">
                        <h1 style="font-size: 1.2em;text-align: center;margin: 0;font-family: Verdana, Arial, Helvetica, sans-serif;font-weight: bold;border-top: 1px solid black;border-bottom: 1px solid black;width: 100%">Identifiant de connection</h1>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 5px 0;"><strong>$label {$_data['firstname']} {$_data['name']}</strong>,</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;">Vos identifiant de connection :</td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;">Adresse de messagerie : <strong>{$_data['email']}</strong></td>
                </tr>
                <tr>
                    <td style="padding: 5px 0;">Mot de passe : <strong>{$_data['password']}</strong></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td  style="padding-top: 5%;">
                        Ne jamais communiqué à personne vos identifiants de connections!
                    </td>
                </tr>
            </tfoot>
        </table>
        {$this->mailFooter['content']}
    </body>
</html>
HERE;
	}
                
	private function setMailFooter() {
	    $mDetails = new MDetails();
	    $data = $mDetails->Select();
	    strip_xss($data);
	    
	    if ($data['fax'] != null) {
	        $fax = '<td>fax: '. $data['fax'] .'</td>';
	        $colspan = 3;
	    } else {
	        $fax = null;
	        $colspan = 2;
	    }
	    
	    $this->mailFooter['colspan'] = $colspan;
	    $this->mailFooter['content'] = <<<HERE
<table style="border-collapse: collapse;width: 100%;background-color: #e6e6e6;font-size: 0.8em;text-align: center;">
    <tr style="font-size: 0.9em;text-align: center;">
        <td colspan="$colspan" style="border-top: 1px solid black;">
            <a href="http://testveterinarycnam.franceserv.com">www.testveterinarycnam.franceserv.com</a>
        </td>
    </tr>
    <tr>
        <td colspan="$colspan">CAT CLINIC - {$data['street']} - {$data['postal_code']} {$data['city']}</td>
    </tr>
    <tr>
        <td><abbr title="téléphone">Tél</abbr>: {$data['phone']}</td>
        $fax
        <td><strong>Urgences: {$data['emergency']}</strong></td>
    </tr>
</table>
HERE;
	}
}// MMail{}