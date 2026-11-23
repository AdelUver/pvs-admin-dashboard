<?php
declare(strict_types=1);

require_once __DIR__ . '/config/config.php';

error_reporting(E_ALL);
ini_set('display_errors', IS_LOCAL ? '1' : '0');

include_once PROJECT_ROOT . '/routes.php';
