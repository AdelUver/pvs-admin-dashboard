<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'on');

require_once __DIR__ . '/functions/function-db.php';

$username = "adel@gmail.at";
$password = password_hash("adel", PASSWORD_DEFAULT);
$email = "adel@gmail.at";
$first_name = "Adel";
$last_name = "Golnazari";

$sql = "INSERT INTO admin_users SET 
        username='" . $username . "',
        email='" . $email . "',
        password_hash='" . $password . "',
        first_name='" . $first_name . "',
        last_name='" . $last_name . "',
        role='admin',
        is_active=1"
;

$statement = getDB()->exec($sql);

if (!$statement) {
    echo "Fehler";
}
echo "Success";