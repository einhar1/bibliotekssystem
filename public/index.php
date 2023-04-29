<?php
require '../vendor/autoload.php';
ini_set('display_errors', E_ALL);
ini_set('display_startup_errors', E_ALL);
header("Access-Control-Allow-Origin: *");
header('Content-Type:text/html; charset=UTF-8');
//ladda om sidan var 900:de sekund för att kontrollera om sessionen gått ut
header("Refresh:900");
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

use App\controller\controller_startpage;
use App\model\model_startpage;
use App\view\view_startpage;
use App\db\dbcon;

$url = "http://localhost" . $_SERVER['REQUEST_URI'];
$arrurl = parse_url($url);
$url_parts = explode('/', $arrurl['path']);

$db = new dbcon();
$model = new model_startpage($db);
$view = new view_startpage();
$controller = new controller_startpage($model, $view);
session_start();

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (
    time() - $_SESSION['CREATED'] > 900
) {
    // session started more than 30 minutes ago
    session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    $_SESSION['CREATED'] = time();  // update creation time
}

$login = true;

if (isset($_POST['username']) and isset($_POST['password'])) {
    $status = $controller->loggain(htmlspecialchars($_POST['username']), htmlspecialchars($_POST['password']));
    if ($status == "error") {
        $login = false;
    } else {
        $login = true;
    }
}

if (isset($_POST['barcode']) and isset($_POST['amount'])) {
    $controller->pdf($_POST['barcode'], $_POST['amount']);
}

if ($login == true) {
    if ($url_parts[4] == "start") {
        $controller->start();
    } elseif ($url_parts[4] == "lana") {
        $controller->lana();
    } elseif ($url_parts[4] == "lamna") {
        $controller->lamna();
    } elseif ($url_parts[4] == "minsida") {
        $controller->minsida();
    } elseif ($url_parts[4] == "matain") {
        $controller->matain();
    } elseif ($url_parts[4] == "radera") {
        $controller->radera();
    } elseif ($url_parts[4] == "loggaut") {
        $controller->loggaut();
        //skicka användaren till startsidan efter utloggning
        header('Location:start');
    } else {
        $controller->error();
    }
}
