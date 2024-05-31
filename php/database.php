<?php

$host = 'sql7.freesqldatabase.com'; 
$dbname = 'sql7710600';
$username = 'sql7710600'; 
$password = 'pH8mCPUC9c'; 

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'Erreur de connexion : ' . $e->getMessage();
}