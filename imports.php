<?php
include './config.php';
include './lib/db.php';
include './lib/users.php';
include './lib/merch.php';
include './lib/colors.php';

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

initSession();
$isIndex = basename($_SERVER['SCRIPT_FILENAME']) == 'control.php';

if (isAuth()) {
    // User is authorized
    if ($isIndex) {
        // Current file is index(control).
        // No need to show auth form.
        // Let's show positions page
        header("Location: merch.php");
        die();
    }
} else {
    // User is not authorized
    if (!$isIndex) {
        // Current file is not index(control).
        // We need to redirect user to index page
        header("Location: control.php");
        die();
    }
}

/*var_dump($_POST);
echo '<br/>';
var_dump($_SESSION);*/
