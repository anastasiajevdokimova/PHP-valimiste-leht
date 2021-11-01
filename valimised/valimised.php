<?php
require_once ('conf.php');
global $yhendus;
//Update käsk
if(isSet($_REQUEST["haal"])){
    $kask=$yhendus->prepare('UPDATE valimised SET punktid=punktid+1 WHERE id=?');
    $kask->bind_param('i',$_REQUEST["haal"]);
    $kask->execute();
    header ("Location: http://localhost:63342/valimised/valimised.php");
}
//kommentaari lisamine
if(isSet($_REQUEST['uus_kommentaar'])){
    $kask=$yhendus->prepare('UPDATE valimised SET kommentaarid=CONCAT(kommentaarid, ?) WHERE id=?');
    $kommentlisa=$_REQUEST['kommentaar']."\n";
    $kask->bind_param('si', $kommentlisa,$_REQUEST['uus_kommentaar']);
    $kask->execute();
    header ("Location: $_SERVER[PHP_SELF]");

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

    <h1>Valimiste leht</h1>

<?php
//valimiste tabeli sisu vaatamine andmebaasist
    global $yhendus;
    $kask=$yhendus->prepare('SELECT id, nimi, punktid, kommentaarid FROM valimised WHERE avalik=1 ORDER BY punktid DESC');
    $kask->bind_result($id, $nimi, $punktid, $kommentaarid);
    $kask->execute();
    echo "<div class='valimised'>";
    echo "<table>";
    echo "<tr><th>Nimi</th><th>Punktid</th><th>Anna oma hääl</th><th>Kommentaarid</th>";
    while($kask->fetch()){
        echo "<tr>";
        echo "<td>".htmlspecialchars($nimi)."</td>";
        echo "<td>".($punktid)."</td>";
        echo "<td class='punkt'><a href='?haal=$id'>Lisa +1 punkt</a></td>";
        echo "<td>".nl2br(htmlspecialchars($kommentaarid))."</td>";
        echo "<td>
<form action='?'>
<input type='hidden' name='uus_kommentaar' value='$id'>
<input type='text' name='kommentaar'>
<input type='submit' value='Lisa kommentaar'>
</form>
</td>";
        echo "</tr>";
    }
    echo "</table>";
echo "</div>";
$yhendus->close();
?>
</body>
</html>
<?php

/*CREATE TABLE valimised(
    id int PRIMARY KEY AUTO_INCREMENT,
    nimi varchar(100),
    lisamisaeg datetime,
    punktid int DEFAULT 0,
    kommentaarid text,
    avalik int DEFAULT 1
);
INSERT INTO valimised(nimi, lisamisaeg, punktid, kommentaarid, avalik)
VALUES ('Karlson', '2021-11-1', 10, 'Hea raamat', 1);

SELECT * FROM valimised*/
?>