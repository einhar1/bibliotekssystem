<?php

namespace App\model;

/*
I efterhand inser jag att det hade varit enklare att skapa en funktion som hämntar titel och författare
första gången boken läggs in och sedan lagrar det i databasen istället för att hämta det på nytt varje
gång. Detta hade lett till snabbare laddtider och ett minskat antal requests mot API:t.

Jag är medveten om att jag har flera funktioner som är snarlika. Jag funderade på att slå samman dessa
till en gemensam funktion, men skillnaderna är endå såpass stora mellan de att det inte skulle bli 
effektivt.
*/

class model_startpage
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getBookList()
    {

        $books = $this->db->getBooks();

        foreach ($books as $key => $book) {
            
            //hämta data från API:t
            $data = file_get_contents("https://libris.kb.se/xsearch?query=isbn:" . $book["ISBN"] . "&format=json");
            
            $decodedData = json_decode($data);

            //lägg in datan i en array
            $filteredData[$key] = array(
                'ISBN' => $book["ISBN"],
                'bokId' => $book["streckkodsnr_pk"],
                'title' => $decodedData->{'xsearch'}->{'list'}[0]->{'title'},
                'author' => $decodedData->{'xsearch'}->{'list'}[0]->{'creator'},
                'identifier' => $decodedData->{'xsearch'}->{'list'}[0]->{'identifier'},
                'count' => $book["tillgänglig"]
            );

        }

        //sortera böckerna i bokstavsordnings
        usort($filteredData, function ($a, $b) {
            return strcmp($a["title"], $b["title"]);
        });

        return $filteredData;
    }

    public function lana($bokId, $var)
    {
        if ($var == "utlånad") {
            $ISBN = $this->db->lanaBok($bokId);
        } elseif ($var == "tillgänglig") {
            $ISBN = $this->db->lamnaBok($bokId);
        }

        if ($ISBN == "fel") {
            return "fel";
        } elseif ($ISBN == "fel2") {
            return "fel2";
        } elseif ($ISBN == "fel3") {
            return "fel3";
        } elseif ($ISBN == "felanvändare") {
            return "felanvändare";
        } else {
            $data = file_get_contents("https://libris.kb.se/xsearch?query=isbn:" . $ISBN . "&format=json");

            $decodedData = json_decode($data);

            $filteredData = array(
                'title' => $decodedData->{'xsearch'}->{'list'}[0]->{'title'},
                'author' => $decodedData->{'xsearch'}->{'list'}[0]->{'creator'},
                'identifier' => $decodedData->{'xsearch'}->{'list'}[0]->{'identifier'}
            );

            if ($filteredData['author'] != null) {
                $filteredData['var2'] = " av ";
            } else {
                $filteredData['var2'] = " ";
            }

            return $filteredData;
        }
    }
    
    public function minSida()
    {
        $books = $this->db->hemlan();

        foreach ($books as $key => $book) {

            $data = file_get_contents("https://libris.kb.se/xsearch?query=isbn:" . $book[0]["ISBN"] . "&format=json");

            $decodedData = json_decode($data);

            $filteredData[$key] = array(
                'streckkodsnr' => $book[0]["streckkodsnr_pk"],
                'date' => substr($book[0]["date"], 0, 10), //ta bort tiden från utlåningsdatumet
                'title' => $decodedData->{'xsearch'}->{'list'}[0]->{'title'},
                'author' => $decodedData->{'xsearch'}->{'list'}[0]->{'creator'},
                'identifier' => $decodedData->{'xsearch'}->{'list'}[0]->{'identifier'}
            );

        }
        
        return $filteredData;
    }

    public function minSidaAdm()
    {
        $results = $this->db->minSidaAdm();

        foreach ($results as $key => $book) {

            $data = file_get_contents("https://libris.kb.se/xsearch?query=isbn:" . $book["ISBN"] . "&format=json");

            $decodedData = json_decode($data);

            $filteredData[$key] = array(
                'ISBN' => $book["ISBN"],
                'title' => $decodedData->{'xsearch'}->{'list'}[0]->{'title'},
                'author' => $decodedData->{'xsearch'}->{'list'}[0]->{'creator'},
                'identifier' => $decodedData->{'xsearch'}->{'list'}[0]->{'identifier'},
                'streckkodsnr' => $book["streckkodsnr"],
                'namn' => $book["namn"],
                'date' => substr($book["date"], 0, 10) //filtrera bort tiden från utlåningsdatumet
            );

        }

        return $filteredData;
    }

    public function matain($ISBN)
    {
        $data = file_get_contents("https://libris.kb.se/xsearch?query=isbn:" . $ISBN . "&format=json");

        $decodedData = json_decode($data);

        if (empty($decodedData->{'xsearch'}->{'list'}[0]->{'title'})) {
            return "fel";
        } else {
            $streckkodsnr = $this->db->mataIn($ISBN);
        }

        $filteredData = array(
            'title' => $decodedData->{'xsearch'}->{'list'}[0]->{'title'},
            'author' => $decodedData->{'xsearch'}->{'list'}[0]->{'creator'},
            'identifier' => $decodedData->{'xsearch'}->{'list'}[0]->{'identifier'},
            'streckkodsnr' => $streckkodsnr
        );

        if ($filteredData['author'] != null) {
            $filteredData['var2'] = " av ";
        } else {
            $filteredData['var2'] = " ";
        }

        return $filteredData;
    }

    public function deleteBook($bokId)
    {
        $ISBN = $this->db->deleteBook($bokId);
        if ($ISBN == "fel1") {
            return "fel1";
        } elseif ($ISBN == "fel2") {
            return "fel2";
        } else {
            $data = file_get_contents("https://libris.kb.se/xsearch?query=isbn:" . $ISBN . "&format=json");

            $decodedData = json_decode($data);

            $filteredData = array(
                'streckkodsnr' => $bokId,
                'title' => $decodedData->{'xsearch'}->{'list'}[0]->{'title'},
                'author' => $decodedData->{'xsearch'}->{'list'}[0]->{'creator'},
                'identifier' => $decodedData->{'xsearch'}->{'list'}[0]->{'identifier'}
            );

            if ($filteredData['author'] != null) {
                $filteredData['var2'] = " av ";
            } else {
                $filteredData['var2'] = " ";
            }

            return $filteredData;
        }
    }

    public function loggain($username, $password)
    {
        $status = $this->db->loggain($username, $password);
        if ($status == "error") {
            return "error";
        } else {
            session_regenerate_id(true);
            $_SESSION["username"] = $username;
            $_SESSION["name"] = $status->namn;
            $_SESSION["role"] = $status->roll;
            return "success";
        }
    }

    public function loggaut()
    {
        session_destroy();
    }

}
