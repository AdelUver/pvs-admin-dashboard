<?php
require_once __DIR__ . '/config/config.php';
require_once FUNCTIONS_PATH . '/function-db.php';

$username = "adel.golnazari@uver.at";
$password = password_hash("testtest", PASSWORD_DEFAULT);
$email = "adel.golnazari@uver.at";
$first_name = "Adel";
$last_name = "Golnazari";

$sql = "INSERT INTO admin_users SET 
        username='" . $username . "',
        email='" . $email . "',
        password_hash='" . $password . "',
        first_name='" . $first_name . "',
        last_name='" . $last_name . "',
        role='super_admin',
        is_active=1"
;

$statement = getDB()->exec($sql);

if (!$statement) {
    echo "Fehler";
}
echo "Success";