<?php

namespace App\controller;

class controller_startpage {

    private $model;
    private $view;

    public function __construct($model, $view)
    {

        $this->model = $model;
        $this->view = $view;

    }

    public function start()
    {
        $status = null;
        if (isset($_POST['password'])) {
            $status = $this->model->loggain(htmlspecialchars($_POST['password']));
        }
        $this->view->paintTop("start");
        if ($status == "error") {
            $this->view->paintInloggErr();
        }
        if (isset($_SESSION['role'])) {
            $this->view->paintWelcomeAdm();
        } else {
            $this->view->paintWelcome();
        }
        $this->view->paintBottom();
    }

    //vid varje funktion förutom startsidan kontrollerar jag först att användaren är inloggad och om 
    //det krävs admin-behörighet

    public function lana()
    {
        $this->view->paintTop("lana");
        if (isset($_POST['kortid'])) {
            if (isset($_POST['namn'])) {
                $this->model->skapaKonto(htmlspecialchars($_POST['kortid']), htmlspecialchars($_POST['namn']));
                //echo "<script>alert('Kontot är skapat!');</script>";
            }
            $status = $this->model->checkLogin(htmlspecialchars($_POST['kortid']));
            if ($status == "newusr") {
                $this->view->paintNewUsr($_POST['kortid']);
            } elseif (isset($status)) {
                if (isset($_POST['bokid'])) {
                    $utlan = $this->model->lana(htmlspecialchars($_POST['bokid']), "utlånad", $status[0]['lånekortsnr_pk']);
                    if ($utlan == "fel") {
                        $this->view->paintErr("utlånad av någon annan");
                    } elseif ($utlan == "fel2") {
                        $this->view->paintErr2();
                    } elseif ($utlan == "fel3") {
                        $this->view->paintErr3();
                    } else {
                        $this->view->paintConf($utlan, "lånat", $status[0]['namn']);
                    }
                } 
                $this->view->paintUtlan($status);
            }
        } else {
            $this->view->paintLogin("lana");
        }
        $this->view->paintBottom();
    }

    public function lamna()
    {
        $this->view->paintTop("lamna");
        if (isset($_POST['bokid'])) {
            $utlan = $this->model->lana(htmlspecialchars($_POST['bokid']), "tillgänglig", "");
            if ($utlan == "fel") {
                $this->view->paintErr("tillbakalämnad");
            } elseif ($utlan == "fel3") {
                $this->view->paintErr3();
            } else {
                $this->view->paintConf($utlan, "lämnat tillbaka", $utlan['kortid']);
            }
        }
        $this->view->paintLamna();
        $this->view->paintBottom();
    }

    public function minsida()
    {
        $this->view->paintTop("minsida");
        if (isset($_SESSION['role'])) {
            $arrBooks = $this->model->minSidaAdm();
            $this->view->paintMinSidaAdm($arrBooks);
        } elseif (isset($_POST['kortid'])) {
            $arrBooks = $this->model->minSida(htmlspecialchars($_POST['kortid']));
            $this->view->paintMinSida($arrBooks);
        } else {
            $this->view->paintLogin("minsida");
        }
        $this->view->paintBottom();
    }

    public function bocker()
    {
        $this->view->paintTop("bocker");
        if (isset($_SESSION['role'])) {
            if (isset($_POST['bokIdAll'])) {
                $bok = $this->model->deleteBook(htmlspecialchars($_POST['bokIdAll']), 'all');
                if ($bok == "fel1") {
                    $this->view->paintErrRadera1($bok);
                } else {
                    $this->view->paintConfRaderaAll($bok);
                }
            }
            $arrBooks = $this->model->getBookList();
            $this->view->paintBooks($arrBooks);
        } else {
            $this->view->paintAdmNeeded();
        }
        $this->view->paintBottom("bocker");
    }

    public function pdf($nummer, $antal, $titel)
    {
        $this->model->generatePDF($nummer, $antal, $titel);
    }

    public function matain()
    {
        $this->view->paintTop("matain");
        if (isset($_SESSION['role'])) {
            if (isset($_POST['isbn']) and isset($_POST['antal'])) {
                $bok = $this->model->matain(htmlspecialchars($_POST['isbn']), htmlspecialchars($_POST['antal']));
                if ($bok == "fel") {
                    $this->view->paintErrMataIn($bok);
                } else {
                    $this->view->paintConfMataIn($bok, htmlspecialchars($_POST['antal']));
                }
            }
            $this->view->paintForm();
        } else {
            $this->view->paintAdmNeeded();
        }
        $this->view->paintBottom();
    }

    public function radera()
    {
        $this->view->paintTop("radera");
        if (isset($_SESSION['role'])) {
            if (isset($_POST['bokId'])) {
                $bok = $this->model->deleteBook(htmlspecialchars($_POST['bokId']), 'one');
                if ($bok == "fel1") {
                    $this->view->paintErr3($bok);
                } else {
                    $this->view->paintConfRadera($bok);
                }
            }
            $this->view->paintFormDel();
        } else {
            $this->view->paintAdmNeeded();
        }
        $this->view->paintBottom();
    }
    public function loggaut()
    {
        $this->model->loggaut();
    }

    public function error()
    {
        $this->view->paintTop("error");
        $this->view->paintBottom();
    }

}
?>