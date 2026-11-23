<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

//C:/xampp/htdocs/Uver/loginPVS
$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'] . '/Uver/loginPVS';

$baseurl = '/Uver/loginPVS';
global $baseurl;

include_once $_SERVER['DOCUMENT_ROOT'] . '/functions/function-login.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/routes.php';
