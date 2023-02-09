<?php
session_set_cookie_params([
    'lifetime' => 86400,
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_save_path($GLOBALS['basePath'] . 'sessions');
session_start();
include_once $GLOBALS['basePath'] . 'vendor/autoload.php';
include_once $GLOBALS['basePath'] . 'App/routes.php';
session_commit();