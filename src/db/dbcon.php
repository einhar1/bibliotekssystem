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

    public function getBooks()
    {
        $stmt = $this->pdo->query('SELECT * , sum(case `status` when "tillgänglig" then 1 else 0 end) tillgänglig FROM böcker group by ISBN');
        return $stmt->fetchAll();
    }
    public function lanaBok($bokId)
    {
        $stmt = $this->pdo->query('SELECT `status` FROM `böcker` WHERE streckkodsnr_pk=' . $bokId);
        $status = $stmt->fetchColumn();
        
        if ($status == "utlånad" and (empty($status) == false)) {
            $stmt = $this->pdo->query('SELECT lånekortsnr_fk FROM utlån WHERE streckkodsnr_fk = ' . $bokId);
            if ($stmt->fetchColumn() == $_SESSION['username']) {
                return "fel2";
            } else {
                return "fel";
            }
        } elseif ($status == "tillgänglig") {
            $this->pdo->query('UPDATE `böcker` SET `status` = "utlånad" WHERE `böcker`.`streckkodsnr_pk` = ' . $bokId);
            $this->pdo->query('INSERT INTO `utlån` (`streckkodsnr_fk`, `lånekortsnr_fk`) VALUES (' . $bokId . ', ' . $_SESSION['username'] . ')');
            $stmt = $this->pdo->query('SELECT `ISBN` FROM `böcker` WHERE streckkodsnr_pk=' . $bokId);
            return $stmt->fetchColumn();
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
            $stmt = $this->pdo->query('SELECT * FROM utlån WHERE streckkodsnr_fk = ' . $bokId . ' AND lånekortsnr_fk = ' . $_SESSION['username']);
            if (empty($stmt->fetchAll())) {
                return "felanvändare";
            } else {
                $this->pdo->query('DELETE FROM utlån WHERE streckkodsnr_fk = ' . $bokId . ' AND lånekortsnr_fk = ' . $_SESSION['username']);
                $this->pdo->query('UPDATE `böcker` SET `status` = "tillgänglig" WHERE `böcker`.`streckkodsnr_pk` = ' . $bokId);
                $stmt = $this->pdo->query('SELECT `ISBN` FROM `böcker` WHERE streckkodsnr_pk=' . $bokId);
                return $stmt->fetchColumn();
            }
        }
    }
    public function hemlan()
    {
        $stmt = $this->pdo->query('SELECT * FROM utlån where lånekortsnr_fk = ' . $_SESSION['username']);
        $numbers = $stmt->fetchAll();
        foreach ($numbers as $key => $number) {
            $stmt = $this->pdo->query('SELECT * FROM böcker where streckkodsnr_pk = ' . $number['streckkodsnr_fk']);
            $books[$key] = $stmt->fetchAll();
            $books[$key][0]['date'] = $number['utlåningsdatum'];
        }
        return $books;
    }
    public function minSidaAdm()
    {
        $stmt = $this->pdo->query('SELECT * FROM utlån ORDER BY lånekortsnr_fk');
        $utlans = $stmt->fetchAll();
        foreach ($utlans as $key => $utlan) {
            $stmt = $this->pdo->query('SELECT namn FROM låntagare WHERE lånekortsnr_pk = ' . $utlan['lånekortsnr_fk']);
            $namn = $stmt->fetchColumn();
            $stmt = $this->pdo->query('SELECT ISBN FROM böcker WHERE streckkodsnr_pk = ' . $utlan['streckkodsnr_fk']);
            $ISBN = $stmt->fetchColumn();
            $result[$key] = array(
                'namn' => $namn,
                'ISBN' => $ISBN,
                'date' => $utlan['utlåningsdatum'],
                'kortnr' => $utlan['lånekortsnr_fk'],
                'streckkodsnr' => $utlan['streckkodsnr_fk']
            );
        }
        return $result;
    }
    public function mataIn($ISBN, $antal)
    { 
        for ($i=0; $i < $antal; $i++) {
            $this->pdo->query("INSERT INTO `böcker` (`streckkodsnr_pk`, `ISBN`, `status`) VALUES (NULL, '" . $ISBN . "', 'tillgänglig')");
        }
        return $this->pdo->lastInsertId();
    }
    public function deleteBook($bokId)
    {
        $stmt = $this->pdo->query('SELECT `status` FROM `böcker` WHERE streckkodsnr_pk=' . $bokId);
        $status = $stmt->fetchColumn();
        if ($status == "utlånad" and !empty($status)) {
            return "fel2";
        } elseif ($status == "tillgänglig") {
            $stmt = $this->pdo->query("SELECT ISBN FROM böcker WHERE streckkodsnr_pk = " . $bokId);
            $this->pdo->query("DELETE FROM böcker WHERE `böcker`.`streckkodsnr_pk` = " . $bokId);
            return $stmt->fetchColumn();
        } else {
            return "fel1";
        }
    }
    public function loggain($username, $password)
    {
        try {
            $stmt = $this->pdo->query('SELECT pin FROM låntagare WHERE lånekortsnr_pk = ' . $username);
            $pass = $stmt->fetchColumn();
            if (empty($pass)) {
                return "error";
            } elseif ($pass == $password) {
                $stmt = $this->pdo->query('SELECT namn, roll FROM låntagare WHERE lånekortsnr_pk = ' . $username);
                return $stmt->fetchObject();
            } else {
                return "error";
            }
        } catch (\Throwable $th) {
            return "error";
        }
        
    }
}
