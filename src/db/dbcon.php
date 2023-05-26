<?php

namespace App\db;

use PDO;

class dbcon
{

    public $pdo;

    public function __construct()
    {

        $host = '127.0.0.1';
        $db   = 'bibliotek';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    //hämtar alla böcker från databasen
    public function getBooks()
    {
        $stmt = $this->pdo->query('SELECT * , sum(case `status` when "tillgänglig" then 1 else 0 end) "tillgänglig" , COUNT(*) "totalt" FROM böcker group by ISBN');
        return $stmt->fetchAll();
    }

    public function lanaBok($bokId, $kortid)
    {
        $stmt = $this->pdo->query('SELECT `status` FROM `böcker` WHERE streckkodsnr_pk=' . $bokId);
        $status = $stmt->fetchColumn();
        
        if ($status == "utlånad" and !empty($status)) {
            $stmt = $this->pdo->query('SELECT lånekortsnr_fk FROM utlån WHERE streckkodsnr_fk = ' . $bokId);
            if ($stmt->fetchColumn() == $kortid) {
                return "fel2";
            } else {
                return "fel";
            }
        } elseif ($status == "tillgänglig") {
            $this->pdo->query('UPDATE `böcker` SET `status` = "utlånad" WHERE `böcker`.`streckkodsnr_pk` = ' . $bokId);
            $this->pdo->query('INSERT INTO `utlån` (`streckkodsnr_fk`, `lånekortsnr_fk`) VALUES (' . $bokId . ', "' . $kortid . '")');
            $stmt = $this->pdo->query('SELECT `namn` FROM `låntagare` WHERE lånekortsnr_pk="' . $kortid . '"');
            $data['namn'] = $stmt->fetchColumn();
            $stmt = $this->pdo->query('SELECT * FROM `böcker` WHERE streckkodsnr_pk=' . $bokId);
            $data['bok'] = $stmt->fetchAll();
            return $data;
        }
        return "fel3";
    }

    public function lamnaBok($bokId)
    {
        $stmt = $this->pdo->query('SELECT `status` FROM `böcker` WHERE streckkodsnr_pk=' . $bokId);
        $status = $stmt->fetchColumn();

        if ($status == "tillgänglig") {
            return "fel";
        } elseif ($status == "utlånad") {
            $stmt = $this->pdo->query('SELECT `lånekortsnr_fk` FROM `utlån` WHERE streckkodsnr_fk=' . $bokId);
            $kortid = $stmt->fetchColumn();
            $stmt = $this->pdo->query('SELECT `namn` FROM `låntagare` WHERE lånekortsnr_pk="' . $kortid . '"');
            $data['namn'] = $stmt->fetchColumn();
            $this->pdo->query('DELETE FROM utlån WHERE streckkodsnr_fk = ' . $bokId);
            $this->pdo->query('UPDATE `böcker` SET `status` = "tillgänglig" WHERE `böcker`.`streckkodsnr_pk` = ' . $bokId);
            $stmt = $this->pdo->query('SELECT * FROM `böcker` WHERE streckkodsnr_pk=' . $bokId);
            $data['bok'] = $stmt->fetchAll();
            return $data;
        } else {
            return "fel3";
        }
    }

    //hämtar alla lånade böcker för en användare
    public function hemlan($kortid)
    {
        $stmt = $this->pdo->query('SELECT * FROM utlån where lånekortsnr_fk = "' . $kortid . '"');
        $numbers = $stmt->fetchAll();
        foreach ($numbers as $key => $number) {
            $stmt = $this->pdo->query('SELECT * FROM böcker where streckkodsnr_pk = ' . $number['streckkodsnr_fk']);
            $books[$key] = $stmt->fetchAll();
            $books[$key][0]['date'] = $number['utlåningsdatum'];
        }
        return $books;
    }

    //hämtar alla böcker som är utlånade
    public function minSidaAdm()
    {
        $stmt = $this->pdo->query('SELECT * FROM utlån');
        $utlans = $stmt->fetchAll();
        foreach ($utlans as $key => $utlan) {
            $stmt = $this->pdo->query('SELECT namn FROM låntagare WHERE lånekortsnr_pk = "' . $utlan['lånekortsnr_fk'] . '"');
            $namn = $stmt->fetchColumn();
            $stmt = $this->pdo->query('SELECT * FROM böcker WHERE streckkodsnr_pk = ' . $utlan['streckkodsnr_fk']);
            $info = $stmt->fetchAll();
            $result[$key] = array(
                'namn' => $namn,
                'ISBN' => $info[0]['ISBN'],
                'title' => $info[0]['titel'],
                'identifier' => $info[0]['identifier'],
                'date' => substr($utlan['utlåningsdatum'], 0, 10),
                'kortnr' => $utlan['lånekortsnr_fk'],
                'streckkodsnr' => $utlan['streckkodsnr_fk']
            );
        }
        return $result;
    }

    //lägger in en ny bok i databasen
    public function mataIn($ISBN, $antal, $titel, $identifier)
    { 
        for ($i=0; $i < $antal; $i++) {
            $this->pdo->query("INSERT INTO `böcker` (`streckkodsnr_pk`, `ISBN`, `titel`, `identifier`, `status`) VALUES (NULL, '" . $ISBN ."', '" . $titel ."', '" . $identifier . "', 'tillgänglig')");
        }
        return $this->pdo->lastInsertId();
    }

    //tar bort en bok från databasen
    public function deleteBook($bokId)
    {
        $stmt = $this->pdo->query('SELECT * FROM `böcker` WHERE streckkodsnr_pk=' . $bokId);
        $status = $stmt->fetchColumn();
        if (!empty($status)) {
            $stmt = $this->pdo->query("SELECT * FROM böcker WHERE streckkodsnr_pk = " . $bokId);
            $this->pdo->query("DELETE FROM böcker WHERE `böcker`.`streckkodsnr_pk` = " . $bokId);
            $this->pdo->query("DELETE FROM utlån WHERE `streckkodsnr_fk` = " . $bokId);
            return $stmt->fetchAll();
        } else {
            return "fel1";
        }
    }

    //tar bort alla böcker med ett visst ISBN från databasen
    public function deleteBookAll($bokId)
    {
        $stmt = $this->pdo->query('SELECT * FROM `böcker` WHERE ISBN = ' . $bokId);
        $status = $stmt->fetchColumn();
        if (!empty($status)) {
            $stmt = $this->pdo->query("SELECT * FROM böcker WHERE ISBN = " . $bokId);
            $data = $stmt->fetchAll();
            $this->pdo->query("DELETE `utlån` FROM `utlån` INNER JOIN `böcker` ON `utlån`.`streckkodsnr_fk` = `böcker`.`streckkodsnr_pk` WHERE `böcker`.`ISBN` = " . $bokId);
            $this->pdo->query("DELETE FROM böcker WHERE `böcker`.`ISBN` = " . $bokId);
            $data[0]['antal'] = $this->pdo->query('SELECT ROW_COUNT()')->fetchColumn();
            return $data;
        } else {
            return "fel1";
        }
    }

    //kontrollerar om en användare redan har ett konto
    public function checkLogin($kortid)
    {
        $stmt = $this->pdo->query('SELECT * FROM `låntagare` WHERE `lånekortsnr_pk` = "' . $kortid . '"');
        if (empty($stmt->fetchAll())) {
            return "newusr";
        } else {
            $stmt = $this->pdo->query('SELECT * FROM `låntagare` WHERE `lånekortsnr_pk` = "' . $kortid . '"');
            return $stmt->fetchAll();
        }
    }

    //skapar ett nytt användarkonto
    public function skapaKonto($kortid, $namn)
    {
        $this->pdo->query("INSERT INTO `låntagare` (`lånekortsnr_pk`, `namn`) VALUES ('" . $kortid . "', '" . $namn . "')");
    }

    //kontrollerar inloggning för lärare
    public function loggain($password)
    {
        $stmt = $this->pdo->query('SELECT * FROM `adminlösen`');
        if ($stmt->fetchColumn() == $password) {
            return "success";
        } else {
            return "error";
        }
    }
}
