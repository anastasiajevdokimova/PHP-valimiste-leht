<?php
require_once ('conf.php');
global $yhendus;
//uue nimi lisamine
if(!empty($_REQUEST['uusnimi'])){
    $kask=$yhendus->prepare('INSERT INTO valimised (nimi, lisamisaeg) VALUES (?, Now())');
    $kask->bind_param('s', $_REQUEST['uusnimi']);
    $kask->execute();
    header ("Location: $_SERVER[PHP_SELF]");
    //$message = "Uus nimi on lisatud!";
    //echo "<script type='text/javascript'>alert('$message');</script>";
    header ("Location: http://localhost:63342/valimised/valimised.php");
}
?>
<!DOCTYPE HTML>
<html lang="et">
<head>
    <title>Valimiste leht</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<ul>
    <li><a href="koduleht.php">Home</a></li>
    <li><a href="valimised.php">Valimised</a></li>
    <li><a href="nimideHaldus.php">Haldus</a></li>
</ul>
<h1> Uue nimi lisamine</h1>
<form action="?">
    <label for="uusnimi">Sisesta nimi</label>
    <input type="text" id="uusnimi" name="uusnimi" placeholder="Uus nimi">
    <input type="submit" value="OK">
</form>
</body>
</html>