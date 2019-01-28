<?php
use Spipu\Html2Pdf\Html2Pdf;

class CPdf {
    
    private $content;
    private $html2pdf;
    private $output;
    private $details;
    
    public function __construct() {
        $this->html2pdf = new Html2Pdf('P', 'A4', 'fr', true, 'UTF-8', array(10, 10, 10, 10));
    }
    
    public function __destruct(){}
    
    public function setContent($_data) {
        $this->content = $_data;
    }
    
    public function setOuputPath($_pathFile) {
        
        $this->output = $_pathFile;
    }
    
    public function pdfGeneration() {
        $this->html2pdf->writeHTML($this->content);
        if ($this->output) {
            $this->html2pdf->output($this->output, 'F');
        } else {
            $this->html2pdf->output();
        }
    }
    
    public function pdfForAppointment($_data) {
//         var_dump($_data);
        
        
        if ($_data['details']['phone'] != null) {
            $fax = $_data['details']['fax'] .'<br />';
            $faxFooter = '<td>'. $_data['details']['fax'] .'</td>';
            $colspan = 3;
        } else {
            $fax = null;
            $faxFooter = null;
            $colspan = 2;
        }
        
        $label = personLabel($_data['form_data']['current_mail']['label']);
        $formtedDate = timeToStringFormat(mktime($_data['form_data']['post']['TIME_H'], $_data['form_data']['post']['TIME_MIN'], 0, $_data['form_data']['post']['DATE_MONTH'], $_data['form_data']['post']['DATE_DAY'], $_data['form_data']['post']['DATE_YEAR']), true);
        $docComment = ($_data['form_data']['post']['DOCTOR_REQU'] != null) ? $_data['form_data']['post']['DOCTOR_REQU'] : '<em>Aucun commentaire supplémentaire de la part du docteur.</em>';
        $todayDate = timeToStringFormat(time());
        
        $this->content = <<<HERE
<page backtop="90mm" backbottom="20mm">
    <page_header>
        <table style="border-collapse: collapse;">
            <tr>
                <td colspan="3">
                    <a href="http://testveterinarycnam.franceserv.com/php/" title="vers CAT CLINIC">
                        <img style="max-width: 190mm;display: block;" src="../img/catclinic_v2.3.2.png" />
                    </a>
                </td>
            </tr>
            <tr>
                <td style="width: 30%">
                    CAT CLINIC<br />
                    {$_data['details']['street']}<br />
                    {$_data['details']['postal_code']} {$_data['details']['city']}<br />
                    tél: {$_data['details']['phone']}<br />
                    $fax
                    <strong><span style="color: #FF0000;">Urgences: {$_data['details']['emergency']}</span></strong><br />
                </td>
                <td style="width: 40%"></td>
                <td style="width: 30%;vertical-align: bottom;">
                    {$_data['form_data']['current_mail']['firstname']} {$_data['form_data']['current_mail']['name']}<br />
                    <a href="mailto:gillesgandner@gmail.com">{$_data['form_data']['current_mail']['email']}</a><br />
                </td>
            </tr>
        </table>
    </page_header>
    <table style="border-collapse: collapse;">
        <tr style="background-color: #cacaca;">
            <td style="height: 20mm;text-align: center;"><h1 style="font-size: 40px;">CONVOCATION</h1></td>
        </tr>
        <tr style="text-align: right;">
            <td style="height: 10mm;padding-right: 30mm;">Le $todayDate</td>
        </tr>
        <tr>
            <td style="height: 28mm;vertical-align: top;line-height: 7mm">
                $label {$_data['form_data']['current_mail']['firstname']} {$_data['form_data']['current_mail']['name']},<br />
                vous avez rendez-vous avec le <strong>$formtedDate</strong> avec le <strong>docteur {$_data['form_data']['post']['DOCTOR']['firstname']} {$_data['form_data']['post']['DOCTOR']['name']}</strong> pour votre <strong>{$_data['form_data']['current_mail']['specie']} {$_data['form_data']['current_mail']['pet_name']}</strong>.
            </td>
        </tr>
        <tr style="background-color: #cacaca"><td style="height: 14mm;"><h2>Commentaire du docteur :</h2></td></tr>
        <tr style="background-color: #e6e6e6">
            <td style="height: 28mm;text-align: center;">$docComment</td>
        </tr>
        <tr>
            <td style="height: 50mm">
                Pour votre rendez-vous veuillez vous munir:<br />
                <ul>
                    <li>de cette convocation <em>(imprimée ou sur votre smartphone ou tablette).</em></li>
                    <li>du carnet de santé de votre animal.</li>
                </ul>
                <p>
                    Si vous ne pouvez pas etre présent à ce rendez-vous, veuillez nous contacter par téléphone au {$_data['details']['phone']}
                    le plus tot possible.
                </p>
            </td>
        </tr>
    </table>

    <page_footer>
        <table style="border-collapse: collapse;text-align: center;margin: 0;">
            <tr><td style="width: 190mm;border-top: 1px solid #0787ce;" colspan="$colspan"><a href="http://www.catclinic.franceserv.com">www.catclinic.franceserv.com</a></td></tr>
            <tr><td colspan="$colspan">CAT CLINIC – {$_data['details']['street']} – {$_data['details']['postal_code']} {$_data['details']['city']}</td></tr>
            <tr><td>tél : {$_data['details']['phone']} </td>$faxFooter<td> urgences : {$_data['details']['emergency']}</td></tr>
        </table>
    </page_footer>
    
</page>
HERE;
    }
}