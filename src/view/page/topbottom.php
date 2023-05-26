<?php

namespace App\view\page;

class topbottom
{

    public function __construct()
    {
    }

    public function top($url)
    {
        echo <<< TOP
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
            <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
            <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
            <title>Teknikprogrammets bibliotek</title>
        </head>
        <style>
            /* Chrome, Safari, Edge, Opera */
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
            }

            /* Firefox */
            input[type=number] {
            -moz-appearance: textfield;
            }

            .button:hover #usr {
                visibility: hidden;
            }

            #logout {
                visibility: hidden;
                position: absolute;
            }

            /* ändrar texten till "logga ut" när muspekaren är över knappen */
            .button:hover #logout {
                visibility: visible;
            }

            #kort {
                color: transparent;
                outline: none;
                border: none;
                cursor: default;
            }

        </style>

        <body>
            <script>
                $(document).ready(function() {
                    //definerar en ny sorterbar och sökbar tabell
                    let table = new DataTable('#utlan', {
                        paging: false,
                        order: [[ 1, "asc" ]]
                    });
                    let table2 = new DataTable('#utlan2', {
                        paging: false,
                        order: [[ 1, "asc" ]],
                        columnDefs: [{ orderable: false, targets: 4 }]
                    });
                    $("#kort").blur(function(){
                        $("#kort").focus();
                    });
                });
            </script>
            <!-- en popup ruta för inloggning -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Logga in som lärare för att se utlån eller lägga in/ta bort böcker.</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="start" method="post">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Lösenord</label>
                            <input autocomplete='off' type="password" class="form-control" id="exampleInputPassword1" name="password" required autofocus>
                        </div>
                        <button type="submit" class="btn btn-primary">Logga in</button>
                    </form>
                </div>
                </div>
            </div>
            </div>
            <!-- en popup ruta för att radera böcker -->
            <div class="modal fade" id="modalConf" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Vill du verkligen radera den här boken?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="bocker" method="post" id='formConf'>
                        <input autocomplete='off' type="hidden" class="form-control" id='inputConf' name="bokIdAll">
                        <button type="submit" class="btn btn-danger">Radera</button>
                    </form>
                </div>
                </div>
            </div>
            </div>
            <nav class="navbar navbar-expand-lg bg-light sticky-top border-bottom border-3">
            <div class="container-fluid">
                <a class="navbar-brand" href="/Webbserverprog/mvc/public/start">Bibliotek</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav me-auto">
        TOP;

        //jag vet att jag hade kunnat göra en gemensam funktion för alla undersidor
        //men då hade jag behövt använda väldigt många olika variebler för att få
        //den aktuella sidan att ha klassen "active"

        if ($url == "lana") {
            echo <<< MENY
            <a class="nav-link active" aria-current="page" href="/Webbserverprog/mvc/public/lana">Låna</a>
            <a class="nav-link" href="/Webbserverprog/mvc/public/lamna">Lämna tillbaka</a>
            MENY;
            //denna if-sats kontrollerar om användaren har admin-behörighet för att styra vilka
            //flikar som användaren ser
            if (isset($_SESSION['role'])) {
                echo <<< MENY
                <a class="nav-link" href="/Webbserverprog/mvc/public/minsida">Lista över utlån</a>
                <a class="nav-link" href="/Webbserverprog/mvc/public/bocker">Lista över böcker</a>
                <a class="nav-link" href="/Webbserverprog/mvc/public/matain">Lägg till böcker</a>
                <a class="nav-link" href="/Webbserverprog/mvc/public/radera">Ta bort böcker</a>
                MENY;
            } else {
                echo' <a class="nav-link" href="/Webbserverprog/mvc/public/minsida">Böcker hemma</a>';
            }
        } elseif ($url == "lamna") {
            echo <<< MENY
            <a class="nav-link" href="/Webbserverprog/mvc/public/lana">Låna</a>
            <a class="nav-link active" aria-current="page" href="/Webbserverprog/mvc/public/lamna">Lämna tillbaka</a>
            MENY;
            if (isset($_SESSION['role'])) {
                echo <<< MENY
                <a class="nav-link" href="/Webbserverprog/mvc/public/minsida">Lista över utlån</a>
                <a class="nav-link" href="/Webbserverprog/mvc/public/bocker">Lista över böcker</a>
                <a class="nav-link" href="/Webbserverprog/mvc/public/matain">Lägg till böcker</a>
                <a class="nav-link" href="/Webbserverprog/mvc/public/radera">Ta bort böcker</a>
                MENY;
            } else {
                echo '<a class="nav-link" href="/Webbserverprog/mvc/public/minsida">Böcker hemma</a>';
            }
        } elseif ($url == "minsida") {
            echo <<< MENY
            <a class="nav-link" href="/Webbserverprog/mvc/public/lana">Låna</a>
            <a class="nav-link" href="/Webbserverprog/mvc/public/lamna">Lämna tillbaka</a>
            MENY;
            if (isset($_SESSION['role'])) {
                echo <<< MENY
                <a class="nav-link active" href="/Webbserverprog/mvc/public/minsida">Lista över utlån</a>
                <a class="nav-link" href="/Webbserverprog/mvc/public/bocker">Lista över böcker</a>
                <a class="nav-link" href="/Webbserverprog/mvc/public/matain">Lägg till böcker</a>
                <a class="nav-link" href="/Webbserverprog/mvc/public/radera">Ta bort böcker</a>
                MENY;
            } else {
                echo '<a class="nav-link active" href="/Webbserverprog/mvc/public/minsida">Böcker hemma</a>';
            }
        } elseif ($url == "bocker") {
            echo <<< MENY
            <a class="nav-link" href="/Webbserverprog/mvc/public/lana">Låna</a>
            <a class="nav-link" href="/Webbserverprog/mvc/public/lamna">Lämna tillbaka</a>
            MENY;
            if (isset($_SESSION['role'])) {
                echo <<< MENY
                <a class="nav-link" href="/Webbserverprog/mvc/public/minsida">Lista över utlån</a>
                <a class="nav-link active" href="/Webbserverprog/mvc/public/bocker">Lista över böcker</a>
                <a class="nav-link" href="/Webbserverprog/mvc/public/matain">Lägg till böcker</a>
                <a class="nav-link" href="/Webbserverprog/mvc/public/radera">Ta bort böcker</a>
                MENY;
            } else {
                echo '<a class="nav-link active" href="/Webbserverprog/mvc/public/minsida">Böcker hemma</a>';
            }
        } elseif ($url == "matain") {
            echo <<< MENY
            <a class="nav-link" href="/Webbserverprog/mvc/public/lana">Låna</a>
            <a class="nav-link" href="/Webbserverprog/mvc/public/lamna">Lämna tillbaka</a>
            MENY;
            if (isset($_SESSION['role'])) {
                echo <<< MENY
                <a class="nav-link" href="/Webbserverprog/mvc/public/minsida">Lista över utlån</a>
                <a class="nav-link" href="/Webbserverprog/mvc/public/bocker">Lista över böcker</a>
                <a class="nav-link active" href="/Webbserverprog/mvc/public/matain">Lägg till böcker</a>
                <a class="nav-link" href="/Webbserverprog/mvc/public/radera">Ta bort böcker</a>
                MENY;
            } else {
                echo '<a class="nav-link" href="/Webbserverprog/mvc/public/minsida">Böcker hemma</a>';
            }
        } elseif ($url == "radera") {
            echo <<< MENY
            <a class="nav-link" href="/Webbserverprog/mvc/public/lana">Låna</a>
            <a class="nav-link" href="/Webbserverprog/mvc/public/lamna">Lämna tillbaka</a>
            MENY;
            if (isset($_SESSION['role'])) {
                echo <<< MENY
                <a class="nav-link" href="/Webbserverprog/mvc/public/minsida">Lista över utlån</a>
                <a class="nav-link" href="/Webbserverprog/mvc/public/bocker">Lista över böcker</a>
                <a class="nav-link" href="/Webbserverprog/mvc/public/matain">Lägg till böcker</a>
                <a class="nav-link active" href="/Webbserverprog/mvc/public/radera">Ta bort böcker</a>
                MENY;
            } else {
                echo '<a class="nav-link" href="/Webbserverprog/mvc/public/minsida">Böcker hemma</a>';
            }
        } elseif ($url == "start" or $url == "error") {
            echo <<< MENY
            <a class="nav-link" href="/Webbserverprog/mvc/public/lana">Låna</a>
            <a class="nav-link" href="/Webbserverprog/mvc/public/lamna">Lämna tillbaka</a>
            MENY;
            if (isset($_SESSION['role'])) {
                echo <<< MENY
                <a class="nav-link" href="/Webbserverprog/mvc/public/minsida">Lista över utlån</a>
                <a class="nav-link" href="/Webbserverprog/mvc/public/bocker">Lista över böcker</a>
                <a class="nav-link" href="/Webbserverprog/mvc/public/matain">Lägg till böcker</a>
                <a class="nav-link" href="/Webbserverprog/mvc/public/radera">Ta bort böcker</a>
                MENY;
            } else {
                echo '<a class="nav-link" href="/Webbserverprog/mvc/public/minsida">Böcker hemma</a>';
            }
        }
        echo "</div>";

        // ändra texten på inloggningsknappen när någon är inloggad
        if (isset($_SESSION["role"])) {
            echo <<< BTN
            <a type="button" href="/Webbserverprog/mvc/public/loggaut" class="btn btn-primary button">
                <span id="logout">Logga ut</span><span id="usr">Inloggad</span>
            </a>
            BTN;
        } else {
            echo <<< BTN
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Lärar-login
            </button>
            BTN;
        }
        echo <<< TOP
            </div>
        </div>
        </nav>
        TOP;

        if ($url == "error") {
            echo "<h2>404</h2>Den här sidan finns inte.";
        }
        echo "<div class='p-2'>";
    }
    public function bottom()
    {
        echo "
        </div>
        <script>
        function clickDel(ISBN) {
            document.forms['formConf'].elements['inputConf'].value = ISBN;
        }
        </script>
        </body>
        </html>";
    }
}
?>