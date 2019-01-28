<?php
global $content;

$vBanner = new VBanner();
$vFooter = new VFooter();
$vContent = new $content['class']();
?>
<!DOCTYPE html>
<html class="no-js" lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/app.css">
        <title><?php echo $content['title'] ?></title>
        
    </head>
    
    <body class="grid-container">
    	<?php $vBanner->showBanner() ?>
        
        <div id="content" class="grid-container">
      	<?php $vContent->{$content['meth']}($content['arg']) ?>
        </div><!-- id="content" -->
          
        <?php $vFooter->showFooter() ?>
        
		<script src="../js/layout.js"></script>
    </body>
</html>
