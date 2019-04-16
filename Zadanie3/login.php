<?php


include 'config.php';


switch ($_GET['type']) {
    case 'ldap':
        $ldapuid = $_GET['username'];
        $ldappass = $_GET['passwd'];
        //     $ldapuid = IS_USER;
        //   $ldappass = IS_PASSWD;

        $dn = 'ou=People, DC=stuba, DC=sk';
        $set = ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
        $ldapconn = ldap_connect("ldap.stuba.sk") or die("Could not connect to LDAP server.");
        $ldaprdn = 'uid=' . $ldapuid . ', OU=People, DC=stuba, DC=sk';

        if (!(isset($_SESSION["id"]))) {
            if ($ldapconn) {

                $bind = @ldap_bind($ldapconn, $ldaprdn, $ldappass);


                if ($bind) {
                    echo "<br /><br />";
                    $sr = ldap_search($ldapconn, $ldaprdn, "uid=" . $ldapuid);
                    $entry = ldap_first_entry($ldapconn, $sr);
                    $results = ldap_search($ldapconn, $dn, "uid=" . $ldapuid, array("givenname", "sn", "employeetype", "mail", "faculty", "cn", "uisid", "uid"));
                    $info = ldap_get_entries($ldapconn, $results);
                    // echo "<pre>";
                    //var_dump($info);
                    // echo "</pre>";
                    session_start();
                    $_SESSION["meno"] = $info[0]['givenname'][0];
                    $_SESSION["priezvisko"] = $info[0]['sn'][0];
                    $_SESSION["id"] = $info[0]['uid'][0];
                    $_SESSION["type"] = $info[0]['employeetype'][0];
                    $id = $_SESSION["id"];
                    $type_login = "LDAP";
                    $time_login = getDatetimeNow();
                    $sql = "INSERT INTO history_login ( username, time_login, type_login) 
                      VALUES (?, ?, ? )";

                    $pdo->prepare($sql)->execute([$id, $time_login, $type_login]);

                    header("location: welcome.php");
                } else {

                    header("location: index.php?signin=0");


                }

            }

            ldap_close($ldapconn);
        }
        break;

    case 'local':

        $ldapuid = $_GET['username'];
        $ldappass = $_GET['passwd'];

        $user = $pdo->query("SELECT * from users WHERE  username = '" . $ldapuid . "'")->fetch();

        if (!(isset($_SESSION["id"]))) {

            $passwd = $user['passwd'];

            if ($passwd == hash('sha256', $ldappass)) {

                session_start();
                $_SESSION["meno"] = $user["name"];
                $_SESSION["priezvisko"] = $user["surname"];
                $_SESSION["id"] = $user["username"];
                $id = $_SESSION["id"];
                $type_login = "Local";

                $time_login = getDatetimeNow();
                $sql = "INSERT INTO history_login ( username, time_login, type_login) 
                      VALUES (?, ?, ? )";

                $pdo->prepare($sql)->execute([$id, $time_login, $type_login]);


                header("location: welcome.php");
            } else {


                header("location: index.php?signin=0");
            }
        }
        break;

}


function getDatetimeNow()
{
    $tz_object = new DateTimeZone('Europe/Bratislava');
    $datetime = new DateTime();
    $datetime->setTimezone($tz_object);
    return $datetime->format('Y\-m\-d\ H:i:s');
}

?>