<?php
global $baseurl;
session_destroy();
header('Location: ' . $baseurl . '/login');

?>