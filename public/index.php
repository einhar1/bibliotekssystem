<?php
require '../vendor/autoload.php';
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
header("Access-Control-Allow-Origin: *");
header('Content-Type:text/html; charset=UTF-8');
header("Refresh:450; url=start"); //ladda om sidan var 15:de minut och skicka tillbaka användaren till startsidan
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

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 450)) {
    // last request was more than 30 minutes ago
    session_unset();     // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (
    time() - $_SESSION['CREATED'] > 450
) {
    // session started more than 30 minutes ago
    session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
    $_SESSION['CREATED'] = time();  // update creation time
}

//kallar på funktionen för att generera en pdf-fil
if (isset($_POST['barcode']) and isset($_POST['amount']) and isset($_POST['titel'])) {
    $controller->pdf($_POST['barcode'], $_POST['amount'], $_POST['titel']);
}

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
} elseif ($url_parts[4] == "bocker") {
    $controller->bocker();
} elseif ($url_parts[4] == "radera") {
    $controller->radera();
} elseif ($url_parts[4] == "loggaut") {
    $controller->loggaut();
    //skicka användaren till startsidan efter utloggning
    header('Location:start');
}
