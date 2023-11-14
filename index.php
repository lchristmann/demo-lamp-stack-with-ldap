<?php

// ------------------------------ Database Demo ------------------------------

$host = 'db';         // service name
$dbname = 'php_docker';
$user = 'php_docker';
$password = 'password';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

$table_name = "php_docker_table";

$query = "SELECT * FROM $table_name";
$stmt = $pdo->query($query);

echo "<h1>Database connection demo</h1>";
echo "<strong>$table_name: </strong>";
while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
    echo "<p>".$row['title']."</p>";
    echo "<p>".$row['body']."</p>";
    echo "<p>".$row['date_created']."</p>";
    echo "<hr>";
}

// ------------------------------ LDAP Demo ------------------------------

# Connect to the LDAP server
$ldapHost = 'ldap';
$ldapPort = 389;
$ldapConnection = ldap_connect("ldap://$ldapHost", $ldapPort);

if (!$ldapConnection) {
    die("Failed to connect to LDAP server");
}

ldap_set_option($ldapConnection, LDAP_OPT_PROTOCOL_VERSION, 3);

# Bind to the LDAP Server
$ldapUsername = 'cn=admin,dc=waldorfconnect,dc=de';
$ldapPassword = 'password';
$ldapBind = ldap_bind($ldapConnection, $ldapUsername, $ldapPassword);

if (!$ldapBind) {
    die("Failed to bind to LDAP server");
}

# Search for LDAP entries
$searchBaseDn = 'ou=People,dc=waldorfconnect,dc=de';
$searchFilter = '(objectClass=inetOrgPerson)';
$searchAttributes = ['cn', 'uid', 'mail'];

$searchResult = ldap_search($ldapConnection, $searchBaseDn, $searchFilter, $searchAttributes);
if ($searchResult) {
    $entries = ldap_get_entries($ldapConnection, $searchResult);
    echo "<h1>LDAP connection demo</h1>";
    for ($i=0; $i<$entries["count"]; $i++) {
        echo "cn: " . $entries[$i]["cn"][0] . " | uid: " . $entries[$i]["uid"][0] . " | email: " . $entries[$i]["mail"][0] . "<br>";
    }
} else {
    die("Search failed");
}