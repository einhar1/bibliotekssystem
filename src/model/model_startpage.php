<?php

namespace App\model;

use TCPDF;

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

        //lägger alla böcker i en array för att enklare kunna extrahera informationen senare
        foreach ($books as $key => $book) {
            
            $filteredData[$key] = array(
                'ISBN' => $book["ISBN"],
                'bokId' => $book["streckkodsnr_pk"],
                'title' => $book["titel"],
                'identifier' => $book["identifier"],
                'countAv' => $book["tillgänglig"],
                'countTot' => $book["totalt"]
            );

        }

        return $filteredData;
    }

    //gemensam funktion för att låna och lämna böcker
    public function lana($bokId, $var, $kortid)
    {
        if ($var == "utlånad") {
            $data = $this->db->lanaBok($bokId, $kortid);
        } elseif ($var == "tillgänglig") {
            $data = $this->db->lamnaBok($bokId);
        }

        //kontrollerar om det har returnerats ett felmeddelande eller inte
        if (is_array($data)) {
            $bokinfo = $data['bok'];
            $kortid = $data['namn'];
        } else {
            $bokinfo = $data;
        }

        if ($bokinfo == "fel") {
            return "fel";
        } elseif ($bokinfo == "fel2") {
            return "fel2";
        } elseif ($bokinfo == "fel3") {
            return "fel3";
        } elseif ($bokinfo == "felanvändare") {
            return "felanvändare";
        } else {
            
            $filteredData = array(
                'title' => $bokinfo[0]["titel"],
                'identifier' => $bokinfo[0]["identifier"],
                'kortid' => $kortid
            );

            return $filteredData;
        }
    }
    
    //se utlån för en elev
    public function minSida($kortid)
    {
        $books = $this->db->hemlan($kortid);

        foreach ($books as $key => $book) {
            $filteredData[$key] = array(
                'streckkodsnr' => $book[0]["streckkodsnr_pk"],
                'date' => substr($book[0]["date"], 0, 10), //ta bort tiden från utlåningsdatumet
                'title' => $book[0]["titel"],
                'identifier' => $book[0]["identifier"]
            );
        }
        
        return $filteredData;
    }

    //se alla utlån för lärare
    public function minSidaAdm()
    {
        return $this->db->minSidaAdm();
    }

    public function matain($ISBN, $antal)
    {
        //hämtar information om boken från API:et
        $data = file_get_contents("https://libris.kb.se/xsearch?query=isbn:" . $ISBN . "&format=json");

        $decodedData = json_decode($data);

        if (empty($decodedData->{'xsearch'}->{'list'}[0]->{'title'})) {
            return "fel";
        }

        //extraherar den nödvändiga informationen från API:et
        $titel = $decodedData->{'xsearch'}->{'list'}[0]->{'title'};
        $identifier = $decodedData->{'xsearch'}->{'list'}[0]->{'identifier'};
        $streckkodsnr = $this->db->mataIn($ISBN, $antal, $titel, $identifier);

        $filteredData = array(
            'title' => $titel,
            'identifier' => $identifier,
            'streckkodsnr' => $streckkodsnr,
            'antal' => $antal
        );

        return $filteredData;
    }

    public function generatePDF($nummer, $antal, $titel)
    {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->setCreator(PDF_CREATOR);
        $pdf->setAuthor('Einar Harri');
        $pdf->setTitle('Streckkoder');

        // set default header data
        $pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Streckkoder för "' . $titel . '"', 'Klistra streckkoderna på böckerna');

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->setHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->setFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/sv.php')) {
            require_once(dirname(__FILE__) . '/lang/sv.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------

        // set a barcode on the page footer
        $pdf->setBarcode(date('Y-m-d H:i:s'));

        // set font
        $pdf->setFont('helvetica', '', 11);

        $pdf->setFont('helvetica', '', 10);

        // define barcode style
        $style = array(
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => false,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255),
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );

        //ritar ut en streckkod för varje bok i ett 6x3 rutnät
        $v = 0;
        while (true) {
            $pdf->AddPage();
            for ($k = 0; $k < 6; $k++) {
                for ($i = 0; $i < 3; $i++) {
                    $pdf->write1DBarcode(strval($nummer - $v), 'MSI', $i * 65 + 16, $k * 37 + 47, '', 18, 0.4, $style, 'N');
                    $v++;
                    if ($v == $antal) {
                        break 3;
                    }
                }
            }
        }

        //Close and output PDF document
        $pdf->Output('streckkoder.pdf', 'I');
    }

    public function deleteBook($bokId, $var)
    {
        //kontrollerar om alla exemlar eller endast en ska tas bort
        if ($var == "one") {
            $data = $this->db->deleteBook($bokId);
        } elseif ($var == "all") {
            $data = $this->db->deleteBookAll($bokId);
        }
        
        if ($data == "fel1") {
            return "fel1";
        } else {
            
        $filteredData = array(
            'streckkodsnr' => $bokId,
            'title' => $data[0]["titel"],
            'ISBN' => $data[0]["ISBN"],
            'antal' => $data[0]["antal"],
            'identifier' => $data[0]["identifier"]
        );

            return $filteredData;
        }
    }
    public function skapaKonto($kortid, $namn)
    {
        $this->db->skapaKonto($kortid, $namn);
    }

    //kontrollerar om en användare har ett konto
    public function checkLogin($kortid)
    {
        $status = $this->db->checkLogin($kortid);
        return $status;
    }
    public function loggain($password)
    {
        $status = $this->db->loggain($password);
        if ($status == "error") {
            return "error";
        } else {
            session_regenerate_id(true);
            $_SESSION["role"] = "admin";
            return "success";
        }
    }
    public function loggaut()
    {
        session_destroy();
    }

}
