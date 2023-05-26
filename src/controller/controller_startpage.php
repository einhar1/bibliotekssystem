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
        //hanterar inloggning
        $status = null;
        if (isset($_POST['password'])) {
            $status = $this->model->loggain(htmlspecialchars($_POST['password']));
        }
        $this->view->paintTop("start");
        if ($status == "error") {
            $this->view->paintInloggErr();
        }

        //skriver ut olika välkommstmeddelanden beroende på om användaren är en lärare eller inte
        if (isset($_SESSION['role'])) {
            $this->view->paintWelcomeAdm();
        } else {
            $this->view->paintWelcome();
        }
        $this->view->paintBottom();
    }

    //låna bok
    public function lana()
    {
        $this->view->paintTop("lana");
        //kontrollerar först om användaren har skannat sitt kort
        if (isset($_POST['kortid'])) {
            //om kortet inte finns i databasen får användaren skapa ett nytt konto
            if (isset($_POST['namn'])) {
                $this->model->skapaKonto(htmlspecialchars($_POST['kortid']), htmlspecialchars($_POST['namn']));
            }
            $status = $this->model->checkLogin(htmlspecialchars($_POST['kortid']));
            if ($status == "newusr") {
                $this->view->paintNewUsr($_POST['kortid']);
            } elseif (isset($status)) {
                //om användaren skannat sitt kort och sedan skannat en bok så lånas boken ut
                if (isset($_POST['bokid'])) {
                    $utlan = $this->model->lana(htmlspecialchars($_POST['bokid']), "utlånad", $status[0]['lånekortsnr_pk']);
                    //olika felmeddelanden som kan skrivas ut
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
                //om kortet är skannat men ingen bok är skannad så visas formuläret för utlåning
                $this->view->paintUtlan($status);
            }
        } else {
            //om användaren inte skannat sitt kort visas formuläret för att logga in
            $this->view->paintLogin("lana");
        }
        $this->view->paintBottom();
    }

    //ungefär samma process som att låna en bok fast utan inloggning
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

    //om användaren är en lärare så visas alla utlånade böcker, annars visas bara användarens egna böcker
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

    //visar alla böcker i databasen och möjliggör borttagning av böcker
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

    //om man vill radera endast en bok
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