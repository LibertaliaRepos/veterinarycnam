<?php
require '../inc/require.inc.php';

$email = 'gilles.gandnerfravceserv.com';

$test = filter_var($email, FILTER_VALIDATE_EMAIL);

var_dump($test);