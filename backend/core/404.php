<?php
if(basename(__FILE__) == basename($_SERVER['PHP_SELF'])) send_404();
# This function will send an imitation 404 page if the user
# types in this files filename into the address bar.
# only files connecting with in the same directory as this
# file will be able to use it as well.
function send_404()
{
    header('HTTP/1.x 404 Not Found');
?>
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="de" xml:lang="de">
<head>
<title>Objekt nicht gefunden!</title>
<link rev="made" href="mailto:postmaster@localhost" />
<style type="text/css"><!--/*--><![CDATA[/*><!--*/ 
    body { color: #000000; background-color: #FFFFFF; }
    a:link { color: #0000CC; }
    p, address {margin-left: 3em;}
    span {font-size: smaller;}
/*]]>*/--></style>
</head>

<body>
<h1>Objekt nicht gefunden!</h1>
<p>


    Der angeforderte URL konnte auf dem Server nicht gefunden werden.

  

    Sofern Sie den URL manuell eingegeben haben,
    &uuml;berpr&uuml;fen Sie bitte die Schreibweise und versuchen Sie es erneut.

  

</p>

<p>
Sofern Sie dies f&uuml;r eine Fehlfunktion des Servers halten,
informieren Sie bitte den 
<a href="mailto:postmaster@localhost">Webmaster</a>
hier&uuml;ber.

</p>

<h2>Error 404</h2>
<address>
  <a href="/">localhost</a><br />
  <span>Apache/2.4.10 (Win32) OpenSSL/1.0.1i PHP/5.5.15</span>
</address>
</body>
</html>

<?php
}
 
# In any file you want to connect to the database, 
# and in this case we will name this file db.php 
# just add this line of php code (without the pound sign):
# include"db.php";
