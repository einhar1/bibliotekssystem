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
    public function paintBooks($arrBooks)
    {

        echo <<< ARTIKEL
            <h1>Hej och välkommen till biblioteket!</h1><br>
            <h3><u>Följande böcker finns tillgängliga för utlån.</u></h3>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">ISBN</th>
                    <th scope="col">Titel</th>
                    <th scope="col">Författare</th>
                    <th scope="col">Antal tillgängliga</th>
                    </tr>
                </thead>
                <tbody>
            ARTIKEL;
        foreach ($arrBooks as $key => $value) {
            echo "
                <tr>
                <th scope='row'><a target='blank' class='link' href='" . $value['identifier'] . "'>" . $value['ISBN'] . "</a></th>
                <td>" . $value['title'] . "</td>
                <td>" . $value['author'] . "</td>
                <td>" . $value['count'] . "</td>
                </tr>";
        }
        echo <<< ARTIKEL
                </tbody>
            </table>
            ARTIKEL;
    }

    public function paintMinSida($arrBooks)
    {

        echo <<< ARTIKEL
            <h3><u>Du har följande böcker hemma.</u></h3>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Streckkodsnummer</th>
                    <th scope="col">Titel</th>
                    <th scope="col">Författare</th>
                    <th scope="col">Lånad den</th>
                    </tr>
                </thead>
                <tbody>
            ARTIKEL;
        foreach ($arrBooks as $key => $value) {
            echo "
                    <tr>
                    <th scope='row'>" . $value['streckkodsnr'] . "</th>
                    <td><a target='blank' class='link' href='" . $value['identifier'] . "'>" . $value['title'] . "</a></td>
                    <td>" . $value['author'] . "</td>
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
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">Streckkodsnummer</th>
                    <th scope="col">Titel</th>
                    <th scope="col">Författare</th>
                    <th scope="col">Lånad av</th>
                    <th scope="col">Lånad den</th>
                    </tr>
                </thead>
                <tbody>
            ARTIKEL;
        foreach ($arrBooks as $key => $value) {
            echo "
                    <tr>
                    <th scope='row'>" . $value['streckkodsnr'] . "</th>
                    <td><a target='blank' class='link' href='" . $value['identifier'] . "'>" . $value['title'] . "</a></td>
                    <td>" . $value['author'] . "</td>
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

    public function paintUtlan($var)
    {
        if ($var == "låna") {
            $lanalamna = "lana";
        } elseif ($var == "lämna tillbaka") {
            $lanalamna = "lamna";
        }
        echo <<< ARTICLE
        <div class="m-2">
        Vänligen skanna boken du vill $var.
        <form action="$lanalamna" method="POST">
            <div class="mb-3 mt-3">
                <input type="number" name="bokid" class="form-control" placeholder="Streckkodsnummer" autofocus>
            </div>
        </form></div>
        ARTICLE;
    }

    //nedan följer alla felmeddelanden och bekräftelsemeddelanden som kan skrivas ut

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
    public function paintFelAnvandare()
    {
        echo "<h5>Du kan inte lämna tillbaka en bok som någon annan har lånat!</h5>";
    }
    public function paintConf($utlan, $var)
    {
        echo "<h5>Du har nu " . $var . " <b>" . $utlan["title"] . "</b>" . $utlan['var2'] . "<b>" . $utlan["author"] . "</b></h5>";
    }
    public function paintConfMataIn($utlan)
    {
        echo "<h5>Du har nu matat in <b><a target='blank' class='link' href='" . $utlan['identifier'] . "'>" . $utlan["title"] . "</a></b>" . $utlan['var2'] . "<b>" . $utlan["author"] . "</b> i systemet. Bokens tilldelade streckkodsnummer är <b>" . $utlan["streckkodsnr"] . "</b>.</h5>
        <div class='m-2'>
        <form action='matain' method='POST'>
            <div class='mb-3 mt-3'>
                <input type='number' name='barcode' class='form-control' value='" . $utlan["streckkodsnr"] . "' hidden>
                <input type='number' name='amount' class='form-control' value='" . $utlan["antal"] . "' hidden>
                <button type='submit'>Skriv ut pdf</button>
            </div>
        </form></div>";
    }
    public function paintConfRadera($utlan)
    {
        echo "<h5>Du har nu tagit bort <b><a target='blank' class='link' href='" . $utlan['identifier'] . "'>" . $utlan["title"] . "</a></b>" . $utlan['var2'] . "<b>" . $utlan["author"] . "</b> med streckkodsnummer <b>" . $utlan["streckkodsnr"] . "</b> från systemet</h5>";
    }
    public function paintErrMataIn()
    {
        echo "<h5>Ogilltit ISBN-nummer! (finns inte i Libris databas)</h5>";
    }
    public function paintErrRadera1()
    {
        echo "<h5>Den här boken finns inte i systemet!</h5>";
    }
    public function paintErrRadera2()
    {
        echo "<h5>Du kan inte ta bort en bok som är utlånad!</h5>";
    }
    public function paintForm()
    {
        echo <<< ARTICLE
        <div class="m-2">
        Vänligen skanna boken du vill mata in i systemet och ange antalet likadana böcker.
        <form action="matain" method="POST">
            <div class="mb-3 mt-3">
                <input type="number" name="isbn" class="form-control" placeholder="ISBN" autofocus>
            </div>
            <div class="mb-3 mt-3">
                <input type="number" name="antal" class="form-control" placeholder="Antal">
            </div>
            <button class="btn btn-primary" type="submit">Submit</button>
        </form></div>
        ARTICLE;
    }
    public function paintFormDel()
    {
        // Har ingen autofocus på radera-fliken för att förhindra att man raderar av misstag
        echo <<< ARTICLE
        <div class="m-2">
        Vänligen skanna boken du vill ta bort från systemet systemet.
        <form action="radera" method="POST">
            <div class="mb-3 mt-3">
                <input type="number" name="bokId" class="form-control" placeholder="Streckkodsnummer">
            </div>
        </form></div>
        ARTICLE;
    }
    public function paintInloggErr()
    {
        echo "<h4 class='m-2'>Felaktiga inloggningsuppgifter!</h4>";
    }
    public function paintLoginNeeded()
    {
        echo "Du måste logga in med ditt lånekortsnummer för att kunna använda den här funktionen";
    }
    public function paintAdmNeeded()
    {
        echo "Du måste vara administratör för att kunna använda den här funktionen";
    }
}
