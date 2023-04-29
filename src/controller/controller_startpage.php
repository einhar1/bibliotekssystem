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
        $this->view->paintTop("start");
        $arrBooks = $this->model->getBookList();
        $this->view->paintBooks($arrBooks);
        $this->view->paintBottom();
    }

    //vid varje funktion förutom startsidan kontrollerar jag först att användaren är inloggad och om 
    //det krävs admin-behörighet

    public function lana()
    {
        $this->view->paintTop("lana");
        if (isset($_SESSION['username'])) {
            if (isset($_POST['bokid'])) {
                $utlan = $this->model->lana(htmlspecialchars($_POST['bokid']), "utlånad");
                if ($utlan == "fel") {
                    $this->view->paintErr("utlånad av någon annan");
                } elseif ($utlan == "fel2") {
                    $this->view->paintErr2();
                } elseif ($utlan == "fel3") {
                    $this->view->paintErr3();
                } else {
                    $this->view->paintConf($utlan, "lånat");
                }
            }
            $this->view->paintUtlan("låna");
        } else {
            $this->view->paintLoginNeeded();
        }
        $this->view->paintBottom();
    }

    public function lamna()
    {
        $this->view->paintTop("lamna");
        if (isset($_SESSION['username'])) {
            if (isset($_POST['bokid'])) {
                $utlan = $this->model->lana(htmlspecialchars($_POST['bokid']), "tillgänglig");
                if ($utlan == "fel") {
                    $this->view->paintErr("tillbakalämnad");
                } elseif ($utlan == "felanvändare") {
                    $this->view->paintFelAnvandare();
                } else {
                    $this->view->paintConf($utlan, "lämnat tillbaka");
                }
            }
            $this->view->paintUtlan("lämna tillbaka");
        } else {
            $this->view->paintLoginNeeded();
        }
        $this->view->paintBottom();
    }

    public function minsida()
    {
        $this->view->paintTop("minsida");
        if (isset($_SESSION['username'])) {
            if ($_SESSION['role'] == "admin") {
                $arrBooks = $this->model->minSidaAdm();
                $this->view->paintMinSidaAdm($arrBooks);
            } elseif ($_SESSION['role'] == "user") {
                $arrBooks = $this->model->minSida();
                $this->view->paintMinSida($arrBooks);
            }
        } else {
            //$this->view->paintLoginNeeded();
            //$this->model->generate_barcodes([3409818409, 2038458034, 83485933495, 3257893499, 324789573489]);
            //$this->model->generatePDF();
        }
        $this->view->paintBottom();
    }

    public function pdf($nummer, $antal)
    {
        $this->model->generatePDF($nummer, $antal);
    }

    public function matain()
    {
        $this->view->paintTop("matain");
        if (isset($_SESSION['username']) and $_SESSION['role'] == "admin") {
            if (isset($_POST['isbn']) and isset($_POST['antal'])) {
                $bok = $this->model->matain(htmlspecialchars($_POST['isbn']), htmlspecialchars($_POST['antal']));
                if ($bok == "fel") {
                    $this->view->paintErrMataIn($bok);
                } else {
                    $this->view->paintConfMataIn($bok);
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
        if (isset($_SESSION['username']) and $_SESSION['role'] == "admin") {
            if (isset($_POST['bokId'])) {
                $bok = $this->model->deleteBook(htmlspecialchars($_POST['bokId']));
                if ($bok == "fel1") {
                    $this->view->paintErrRadera1($bok);
                } elseif ($bok == "fel2") {
                    $this->view->paintErrRadera2($bok);
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

    public function loggain($username, $password)
    {
        $status = $this->model->loggain($username, $password);

        if ($status == "error") {
            $this->view->paintTop("start");
            $this->view->paintInloggErr();
            $this->view->paintBottom();
            return "error";
        }
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