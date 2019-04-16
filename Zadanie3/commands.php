<?php
include 'config.php';
$ldapuid = IS_USER;
$ldappass = IS_PASSWD;

$dn  = 'ou=People, DC=stuba, DC=sk';
$ldaprdn  = "uid=$ldapuid, $dn";

$ldaphost = "ldap.stuba.sk";

$ldapconn = ldap_connect($ldaphost) or die("Could not connect to $ldaphost");


$set = ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
//ldap_unbind($ldapconn);
ldap_bind($ldapconn, $ldaprdn, $ldappass);


echo "<br /><br />";
$sr = ldap_search($ldapconn, $ldaprdn, "uid=zakova");

$entry = ldap_first_entry($ldapconn, $sr);
$usrId = ldap_get_values($ldapconn, $entry, "uisid")[0];
echo($usrId); echo "<br />";
$usrName = ldap_get_values($ldapconn, $entry, "givenname")[0];
echo($usrName); echo "<br />";
$usrSurname = ldap_get_values($ldapconn, $entry, "sn")[0];
echo($usrSurname); echo "<br />";

echo "<br /><br />";
$results=ldap_search($ldapconn,$dn,"surname=Zakova*",array("givenname","employeetype","surname","mail","faculty","cn","uisid","uid"));
$info=ldap_get_entries($ldapconn,$results);

$i=0;


echo "<pre>";
echo  $info[0];
echo "</pre>";




?>
