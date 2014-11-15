<?php
/* Redirect browser */
$origin = $_SERVER["HTTP_REFERER"]; //FIXXX escape
header("Location: ".$origin."/slingshot/frontend/");
 
/* Make sure that code below does not get executed when we redirect. */
exit;
?>