<?php
require '../inc/require.inc.php';

$data = array (
    'name' => 'advices',
    'html' => file_get_contents('../html/inBDD/advices.html')
);

$mhtml = new MHTML(1);
$mhtml->setValue($data);
$mhtml->modify('Update');
