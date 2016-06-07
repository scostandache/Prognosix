<?php
    require ("../fpdf181/fpdf.php");
    require("../html_table.php");

    $servername = "localhost";
    $username = "serb_costa";
    $password = "pass";
    $dbname = "TW_database";

    $file = basename($_FILES["fileToUpload"]["name"]);
    $typeFile = pathinfo($file, PATHINFO_EXTENSION);

    //$xml2 = simplexml_load_file($_FILES['fileToUpload']['tmp_name']);
    //print_r(count($xml2));

    if($typeFile != "xml"){
        echo "Tipul fisierului trebuie sa fie XML!." . "<br>";
    }
    else
    {
        $connection = new mysqli($servername, $username, $password, $dbname);

        if ($connection->connect_error) {
            die("Connection failed: " . $connection->connect_error);
        }
        //echo "Connected successfully";

        //$sql = "SELECT * FROM" . " studenti";
        //$result = $connection->query($sql);

        //while($row = $result->fetch_assoc()) {
        //echo "id: " . $row["matricola"]. " - Name: " . $row["nume"]. " " . $row["prenume"]. "<br>";
        //}

        $xml = simplexml_load_file($_FILES['fileToUpload']['tmp_name']);
        //print_r($xml);



        $insertStm  = $connection->prepare("UPDATE note
                                            SET luata = ?
                                            WHERE student_matricola = ? and examen_id = ?");

        $cont = 0;
        for ($i = 0; $i < count($xml); $i++) {
            $insertStm->bind_param("isi", $xml->student[$i]->nota , $xml->student[$i]->matricola, $xml->student[$i]->examenid);
            if ($insertStm->execute() == FALSE){
                echo "Fail insert event " . $insertStm->error. "<br>";
            }
            else{
                $cont++;
            }
            /*$query = "UPDATE note
                  SET luata=" . $xml->student[$i]->nota .
                " WHERE student_matricola ='" . $xml->student[$i]->matricola . "' and " . "examen_id =" . $xml->student[$i]->examenid;
            if ($connection->query($query) === FALSE) {
                echo "Fail grades upload: " . $connection->error;
            }*/
            //echo "matricola:" . $xml->student[$i]->matricola . " obiect:" . $xml->student[$i]->obiect . " nota:" . $xml->student[$i]->nota . "<br>";
        }
        mysqli_stmt_close($insertStm);
        mysqli_close($connection);
        $connection = new mysqli($servername, $username, $password, $dbname);





        $sql_info="SELECT nume_obiect, tip, grupa from examene where id_exam=?";

        $info_query=$connection->prepare($sql_info);
        $info_query->bind_param("s",$xml->student[0]->examenid);
        $info_query->execute();
        $info_query->bind_result($nume_obiect,$tip_obiect,$grupa);
        $info_query->fetch();

        $csv_file_name="note_".$grupa."_".preg_replace('/\s+/', '_', $nume_obiect)."_".$tip_obiect.".csv";
        $pdf_file_name="note_".$grupa."_".preg_replace('/\s+/', '_', $nume_obiect)."_".$tip_obiect.".pdf";

        mysqli_close($connection);

        $connection = new mysqli($servername, $username, $password, $dbname);

        $csv_file = fopen("../file_export/$csv_file_name","w");
        $pdf_file="../file_export/$pdf_file_name";

        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',8);
        $pdf->SetX(65);
        $pdf->MultiCell(70,8 , "Note ".strtoupper($tip_obiect)."-".strtoupper($nume_obiect).", Grupa ".$grupa,1 ,'C');
        
        for ($i = 0; $i < count($xml); $i++) {

            $matricola_student="'".str_replace('"','',$xml->student[$i]->matricola )."'";

            $sql_student="SELECT nume, initiala_tatalui, prenume from studenti where matricola=$matricola_student";

            $result = $connection->query($sql_student);

            $row=$result->fetch_assoc();

            $nume_student=$row["nume"];
            $initiala_tata=$row["initiala_tatalui"];
            $prenume_student=$row["prenume"];

            $csv_line=array($nume_student,$initiala_tata,$prenume_student,$xml->student[$i]->nota);
            //$pdf_line=strtoupper($nume_student)." ".strtoupper($initiala_tata).". ".strtoupper($prenume_student)."               ".$xml->student[$i]->nota;
            

            //$pdf->MultiCell(70,8 , $pdf_line,1 ,'C');
            $pdf->SetX(65);
            $pdf->Cell(55,5,strtoupper($nume_student)." ".strtoupper($initiala_tata).". ".strtoupper($prenume_student),1,0,'C',0);

            $pdf->Cell(15,5,$xml->student[$i]->nota,1,0,'C',0);
            $pdf->Ln();



            fputcsv($csv_file, $csv_line);

        }

        fclose($csv_file);

        $pdf->Output($pdf_file,'F');

        mysqli_close($connection);

        $connection = new mysqli($servername, $username, $password, $dbname);

        $report_title="Note ".$nume_obiect." - ".$tip_obiect;
        $report_destined_to=$grupa;
        $report_content="Acestea sunt notele la ".$tip_obiect."ul "." de ".$nume_obiect.": <![CDATA[ </br>".
                        "<a href='http://localhost/Prognosix/download.php?to_dwnd=$csv_file_name'>Fisier CSV</a>  </br>".
                        "<a href='http://localhost/Prognosix/download.php?to_dwnd=$pdf_file_name'>Fisier PDF</a> ]]>";

        $sql_report=$connection->prepare("INSERT into reports(TITLE,CATEGORY,CONTENT,POSTED) VALUES (?,?,?,NOW())");

        $sql_report->bind_param('sss',$report_title,$report_destined_to,$report_content );
        $sql_report->execute();

        mysqli_close($connection);
        header('location:admin_dash.php');
        

    }
?>