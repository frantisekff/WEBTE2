<?php
/**
 * Created by PhpStorm.
 * User: frantisek.ff
 * Date: 9. 3. 2018
 * Time: 20:52
 */


include 'config.php';

$ldapuid = IS_USER;
$ldappass = IS_PASSWD;

$dn  = 'ou=People, DC=stuba, DC=sk';
//$ldaprdn  = "uid=$ldapuid, $dn";

$set = ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

$ldapconn = ldap_connect("ldap.stuba.sk") or die("Could not connect to LDAP server.");
$ldaprdn  = 'uid='.$ldapuid.', OU=People, DC=stuba, DC=sk';

if ($ldapconn) {
    if ($bind = ldap_bind($ldapconn, $ldaprdn, $ldappass)) {

     /* $resultldap = ldap_search($ldapconn, "OU=People, DC=stuba, DC=sk", "uid=" . $ldapuid);
        $info = ldap_get_entries($ldapconn, $resultldap);
        //print_r($info);

        //echo "<pre>";
        echo $info[0];
        //echo "</pre>";*/

        echo "<br /><br />";
        $sr = ldap_search($ldapconn, $ldaprdn, "uid=zakova");
        $entry = ldap_first_entry($ldapconn, $sr);

        $results=ldap_search($ldapconn,$dn,"surname=Zakova*",array("givenname","employeetype","surname","mail","faculty","cn","uisid","uid"));
        $info=ldap_get_entries($ldapconn,$results);

        echo "<pre>";
        var_dump($info);
        echo "</pre>";

        $i=0;
        while ($i <= 3) {
            echo $info[$i]['cn'][0]."<br>";
            echo $info[$i]['givenname'][0]."<br>";
            echo $info[$i]['sn'][0]."<br>";
echo $info[$i]['mail'][0]."<br>";
echo $info[$i]['employeetype'][0]."<br>";
            echo $info[$i]['uisid'][0]."<br>";
            echo $info[$i]['uid'][0]."<br>";
            echo $info[$i]['faculty'][0]."<br><br>";
            $i++;
        }

        foreach ($info[0]["mail"] as $value)
            echo "$value<br />\n";
    }


}

ldap_close($ldapconn);
?>