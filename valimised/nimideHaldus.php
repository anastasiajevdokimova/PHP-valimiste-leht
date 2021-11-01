<?php
require_once ('conf.php');
global $yhendus;
//peitmine, avalik=0
if(isSet($_REQUEST["peitmine"])){
    $kask=$yhendus->prepare('UPDATE valimised SET avalik=0 WHERE id=?');
    $kask->bind_param('i',$_REQUEST["peitmine"]);
    $kask->execute();
}
//avalikustamine, avalik=1
if(isSet($_REQUEST["avamine"])){
    $kask=$yhendus->prepare('UPDATE valimised SET avalik=1 WHERE id=?');
    $kask->bind_param('i',$_REQUEST["avamine"]);
    $kask->execute();
}
//punktide annulleerimine
if(isSet($_REQUEST["annulleerima"])){
    $kask=$yhendus->prepare('UPDATE valimised SET punktid=0 WHERE id=?');
    $kask->bind_param('i',$_REQUEST["annulleerima"]);
    $kask->execute();
}
//nimede kustutamine
if(isSet($_REQUEST["kustuta"])){
    $kask=$yhendus->prepare('DELETE FROM valimised WHERE id=?');
    $kask->bind_param('i',$_REQUEST["kustuta"]);
    $kask->execute();
}
//kommentaarid nullliks
if(isSet($_REQUEST["kommnull"])){
    $kask=$yhendus->prepare('UPDATE valimised SET kommentaarid=" " WHERE id=?');
    $kask->bind_param('i',$_REQUEST["kommnull"]);
    $kask->execute();
}
?>
<!DOCTYPE HTML>
<html lang="et">
<head>
    <title>Haldusleht</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<ul>
    <li><a href="koduleht.php">Home</a></li>
    <li><a href="valimised.php">Valimised</a></li>
    <li><a href="nimideHaldus.php">Haldus</a></li>
</ul>
<h1>Valimistenimede haldus</h1>

<?php
//valimiste tabeli sisu vaatamine andmebaasist
global $yhendus;
$kask=$yhendus->prepare('SELECT id, nimi, punktid, kommentaarid, avalik FROM valimised');
$kask->bind_result($id, $nimi, $punktid, $kommentaarid, $avalik);
$kask->execute();
echo "<div class='haldus'>";
echo "<table>";
echo "<tr><th>Nimi</th><th>Punktid</th><th>Kommentaarid</th><th>Seisund</th><th>Tegevus</th><th>Punktid nulliks</th><th>Kommentaarid nulliks</th><th>Kustuta</th>";
while($kask->fetch()){
    $avatekst="Ava";
    $param="avamine";
    $seisund="peidetud";
    if($avalik==1){
        $avatekst="Peida";
        $param="peitmine";
        $seisund="avatud";
    }

    echo "<tr>";
    echo "<td>".htmlspecialchars($nimi)."</td>";
    echo "<td>".($punktid)."</td>";
    echo "<td>".($kommentaarid)."</td>";
    echo "<td>".($seisund)."</td>";
    echo "<td class='ava'><a href='?$param=$id'>$avatekst</a></td>";
    echo "<td class='null'><a href='$_SERVER[PHP_SELF]?annulleerima=$id'>Punktid nulliks</a></td>";
    echo "<td class='knull'><a href='$_SERVER[PHP_SELF]?kommnull=$id'>Kommentaarid nulliks</a></td>";
    echo "<td class='kustuta'><a href='$_SERVER[PHP_SELF]?kustuta=$id'>Kustuta</a></td>";
    echo "</tr>";
}
echo "</table>";
echo "</div>";
$yhendus->close();
?>
<a href="koduleht.php">Github projekt</a>
</body>
</html>
