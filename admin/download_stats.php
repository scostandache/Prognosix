<?php
    require('..\fpdf181\fpdf.php');

    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "dbtw";

    $connection = new mysqli($servername, $username, $password, $dbname);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',10);

    $pdf->Cell(30,5,'Obiect',1,0,'C',0);
    $pdf->Cell(25,5,'Tip',1,0,'C',0);
    $pdf->Cell(10,5,'An',1,0,'C',0);
    $pdf->Cell(30,5,'Numar studenti',1,0,'C',0);
    $pdf->Cell(45,5,'Numar studenti ghicit',1,0,'C',0);
    $pdf->Cell(20,5,'Procent',1,0,'C',0);

    $pdf->Ln();

    $sql = "SELECT * FROM examene ORDER BY grupa, nume_obiect, tip";
    //echo $sql;

    $result = $connection->query($sql);

    while ($row = $result->fetch_assoc()) {
        $ok = 1;
        $sql2 = "select count(*) from studenti where grupa like '" . $row["grupa"][0] . "%'";

        $result2 = $connection->query($sql2);
        $row2 = $result2->fetch_assoc();
        $nrStudenti = $row2["count(*)"];

        $sql2 = "select count(*) from note where luata is NULL and examen_id = " . $row["id_exam"];
        $result2 = $connection->query($sql2);
        $row2 = $result2->fetch_assoc();


        if ($row2["count(*)"] > 0) {
            $ok = 0;
        }

        $sql2 = "select count(*) from note where luata = ghicita and examen_id =" . $row["id_exam"];
        $result2 = $connection->query($sql2);
        $row2 = $result2->fetch_assoc();
        $nrGhicit = $row2["count(*)"];

        $procent = ($nrGhicit / $nrStudenti) * 100;

        $pdf->Cell(30,5,$row["nume_obiect"],1,0,'C',0);
        $pdf->Cell(25,5,$row["tip"],1,0,'C',0);
        $pdf->Cell(10,5,$row["grupa"][0],1,0,'C',0);
        $pdf->Cell(30,5,$nrStudenti,1,0,'C',0);
        if($ok == 1) {
            $pdf->Cell(45, 5, $nrGhicit, 1, 0, 'C', 0);
        }
        else{
            $pdf->Cell(45, 5, "-", 1, 0, 'C', 0);
        }
        if($ok == 1) {
            $pdf->Cell(20, 5, round($procent, 2) . "%", 1, 0, 'C', 0);
        }
        else{
            $pdf->Cell(20, 5, "-", 1, 0, 'C', 0);
        }

        $pdf->Ln();
    }
    mysqli_close($connection);

    $pdf->Output('statistici.pdf','D');
?>