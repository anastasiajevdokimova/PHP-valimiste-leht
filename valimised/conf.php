<?php
$serverinimi="localhost"; //d101716.mysql.zonevs.eu - eto nazvanie servera
$kasutaja="jevdokimova20"; //d101716_anjevd - pol'zovatel'
$parool="12345987";
$andmebaas="jevdokimova20"; //d101716_esimene - baza dannyh
$yhendus=new mysqli($serverinimi, $kasutaja, $parool, $andmebaas);
$yhendus->set_charset('UTF8');
?>