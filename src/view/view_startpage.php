<?php

namespace App\view;

use App\view\page\topbottom;

class view_startpage
{

    private $topbottom;

    public function __construct()
    {
        $this->topbottom = new topbottom();
    }

    public function paintTop($url)
    {
        $this->topbottom->top($url);
    }
    public function paintBottom()
    {
        $this->topbottom->bottom();
    }
    public function paintWelcome()
    {
        echo <<< ARTIKEL
            <h1>Välkommen till teknikprogrammets bibliotek!</h1><br>
            <h4>Här kan du låna och lämna tillbaka skolböcker.</h4>
            ARTIKEL;
    }
    public function paintWelcomeAdm()
    {
        echo <<< ARTIKEL
            <h1>Välkommen till teknikprogrammets bibliotek!</h1><br>
            <h4>Här kan du som är lärare bland annat se utlånade böcker och lägga in nya böcker i systemet.</h4>
            ARTIKEL;
    }
    public function paintBooks($arrBooks)
    {

        echo <<< ARTIKEL
            <h3><u>Följande böcker finns att låna.</u></h3>
            Knappen "Radera" raderar alla exemplar av den aktuella boken.<br>
            <table class="table table-hover" id="utlan2">
                <thead>
                    <tr>
                    <th scope="col">ISBN</th>
                    <th scope="col">Titel</th>
                    <th scope="col">Tillgängliga</th>
                    <th scope="col">Totalt</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
            ARTIKEL;
        foreach ($arrBooks as $key => $value) {
            echo "
                <tr>
                <th scope='row'><a target='blank' class='link' href='" . $value['identifier'] . "'>" . $value['ISBN'] . "</a></th>
                <td>" . $value['title'] . "</td>
                <td>" . $value['countAv'] . "</td>
                <td>" . $value['countTot'] . "</td>
                <td><button onclick='clickDel(" . $value['ISBN'] . ")' type='button' id='confbtn' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#modalConf'>Radera</button></td>
                </tr>";
                //jag är medveten om att jag har inline javascript här, men jag hitade inget annat sätt att skicka med ISBN-nummret till funktionen.
        }
        echo <<< ARTIKEL
                </tbody>
            </table>
            ARTIKEL;
    }

    public function paintMinSida($arrBooks)
    {
        echo <<< ARTIKEL
            <h3><u>Du har lånat följande böcker.</u></h3>
            <table class="table table-hover" id="utlan">
                <thead>
                    <tr>
                    <th scope="col">Streckkodsnummer</th>
                    <th scope="col">Titel</th>
                    <th scope="col">Datum</th>
                    </tr>
                </thead>
                <tbody>
            ARTIKEL;
        foreach ($arrBooks as $key => $value) {
            echo "
                    <tr>
                    <th scope='row'>" . $value['streckkodsnr'] . "</th>
                    <td><a target='blank' class='link' href='" . $value['identifier'] . "'>" . $value['title'] . "</a></td>
                    <td>" . $value['date'] . "</td>
                    </tr>
                ";
        }
        echo <<< ARTIKEL
                </tbody>
            </table>
            ARTIKEL;
    }

    public function paintMinSidaAdm($arrBooks)
    {
        echo <<< ARTIKEL
            <h3><u>Följande böcker är just nu utlånade.</u></h3>
            <table class="table table-hover" id="utlan">
                <thead>
                    <tr>
                    <th scope="col">Streckkodsnummer</th>
                    <th scope="col">Titel</th>
                    <th scope="col">Lånad av</th>
                    <th scope="col">Datum</th>
                    </tr>
                </thead>
                <tbody>
            ARTIKEL;
        foreach ($arrBooks as $key => $value) {
            echo "
                    <tr>
                    <th scope='row'>" . $value['streckkodsnr'] . "</th>
                    <td><a target='blank' class='link' href='" . $value['identifier'] . "'>" . $value['title'] . "</a></td>
                    <td>" . $value['namn'] . "</td>
                    <td>" . $value['date'] . "</td>
                    </tr>
                ";
        }
        echo <<< ARTIKEL
                </tbody>
            </table>
            ARTIKEL;
    }

    //några av dessa funktioner är sammanslagna för både utlåning och återlämning.
    //det är därför variabeln $var finns med för att skriva ut "låna" eller "lämna"

    public function paintUtlan($data)
    {
        $namn = $data[0]['namn'];
        $kortid = $data[0]['lånekortsnr_pk'];

        //har en gömd submit-knapp för att kunna använda enter för att skicka in formuläret
        //har satt autocomplete till off på alla inputs även om det inte behövs för alla
        echo <<< ARTICLE
        Inloggad som $namn.<br>
        Vänligen skanna boken du vill låna.
        <form action="lana" method="POST">
            <div class="mb-3 mt-3">
                <input autocomplete='off' type="number" name="bokid" class="form-control" placeholder="Streckkodsnummer" autofocus rquired>
                <input autocomplete='off' type="text" name="kortid" class="form-control" value="$kortid" hidden>
                <input autocomplete='off' type="submit" hidden>
            </div>
        </form>
        ARTICLE;
    }

    public function paintLamna()
    {
        echo <<< ARTICLE
        Vänligen skanna boken du vill lämna tillbaka.
        <form action="lamna" method="POST">
            <div class="mb-3 mt-3">
                <input autocomplete='off' type="number" name="bokid" class="form-control" placeholder="Streckkodsnummer" autofocus required>
            </div>
        </form>
        ARTICLE;
    }

    public function paintErr($var)
    {
        echo "<h5>Den här boken är redan " . $var . "!</h5>";
    }
    public function paintErr2()
    {
        echo "<h5>Du har redan lånat den här boken!</h5>";
    }
    public function paintErr3()
    {
        echo "<h5>Ogilltit streckkodsnummer!</h5>";
    }
    public function paintConf($utlan, $var, $namn)
    {
        echo "<h5>Du (" . $namn . ") har nu " . $var . " <b>" . $utlan["title"] . "</b></h5>";
    }
    public function paintConfMataIn($utlan, $antal)
    {
        echo "<h5>Du har lagt in $antal exemplar av <b><a target='blank' class='link' href='" . $utlan['identifier'] . "'>" . $utlan["title"] . "</a></b> i systemet.</h5>
        <b>Varje bok har blivit tilldelad ett unikt streckkodsnummer. Klicka på knappen nedan för att skriva ut streckkoderna och klistra sedan fast en streckkod på varje bok.</b>
        <form action='matain' target='_blank' method='POST'>
            <div class='mb-3 mt-3'>
                <input autocomplete='off' type='number' name='barcode' class='form-control' value='" . $utlan["streckkodsnr"] . "' hidden>
                <input autocomplete='off' type='number' name='amount' class='form-control' value='" . $utlan["antal"] . "' hidden>
                <input autocomplete='off' type='text' name='titel' class='form-control' value='" . $utlan["title"] . "' hidden>
                <button type='submit' class='btn btn-primary'>Skriv ut streckkoder</button>
            </div>
        </form>";
    }
    public function paintConfRadera($utlan)
    {
        echo "<h5>Du har nu raderat <b><a target='blank' class='link' href='" . $utlan['identifier'] . "'>" . $utlan["title"] . "</a></b> med streckkodsnummer <b>" . $utlan["streckkodsnr"] . "</b>.</h5>";
    }
    public function paintConfRaderaAll($utlan)
    {
        echo "<h5>Du har nu raderat " . $utlan['antal'] . " exemplar av <b><a target='blank' class='link' href='" . $utlan['identifier'] . "'>" . $utlan["title"] . "</a></b> med ISBN-nummret <b>" . $utlan["ISBN"] . "</b>.</h5>";
    }
    public function paintErrMataIn()
    {
        echo "<h5>ISBN-nummret finns inte i Libris databas!</h5>";
    }
    public function paintForm()
    {
        echo <<< ARTICLE
        Vänligen skanna boken du vill lägga till och ange antal exemplar.
        <form action="matain" method="POST">
            <div class="mb-3 mt-3">
                <input autocomplete='off' type="number" name="isbn" class="form-control" placeholder="ISBN" autofocus required>
            </div>
            <div class="mb-3 mt-3">
                <input autocomplete='off' type="number" name="antal" class="form-control" placeholder="Antal" required>
            </div>
            <button class="btn btn-primary" type="submit">Lägg till</button>
        </form>
        ARTICLE;
    }
    public function paintLogin($var)
    {
        echo <<< ARTICLE
        Vänligen skanna ditt id-kort.<br>
        (Om det inte fungerar, se till att programmet UIDtoKeyboard är igång)
        <form action="$var" method="POST">
            <div class="mb-3 mt-3">
                <input autocomplete='off' type="password" id="kort" name="kortid" autofocus required>
            </div>
        </form>
        ARTICLE;
    }
    public function paintNewUsr($kortid)
    {
        echo <<< ARTICLE
        Skriv in ditt för- och efternamn för att skapa ett nytt användarkonto.
        <form action="lana" method="POST">
            <div class="mb-3 mt-3">
                <input autocomplete='off' type="text" name="namn" placeholder="Namn" class="form-control" autofocus required>
                <input autocomplete='off' type="text" name="kortid" class="form-control" value="$kortid" hidden>
                <input autocomplete='off' type="submit" hidden>
            </div>
        </form>
        ARTICLE;
    }
    public function paintFormDel()
    {
        // Har ingen autofocus på radera-fliken för att förhindra att man raderar av misstag
        echo <<< ARTICLE
        Vänligen skanna boken du vill ta bort.
        <br>OBS! Den här funktionen tar endast bort det skannade exemplaret, för att ta bort alla exemplar av en bok, använd knappen "Radera" i listan över böcker.
        <form action="radera" method="POST">
            <div class="mb-3 mt-3">
                <input autocomplete='off' type="number" name="bokId" class="form-control" placeholder="Streckkodsnummer" required>
            </div>
        </form>
        ARTICLE;
    }
    public function paintInloggErr()
    {
        echo "<h4 class='text-danger'>Fel lösenord!</h4>";
    }
    public function paintAdmNeeded()
    {
        echo "Du måste logga in som lärare för att kunna använda den här funktionen.";
    }
}
