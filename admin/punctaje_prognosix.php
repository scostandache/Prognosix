<?php
ini_set("display_errors", 0);
require ("../fpdf181/fpdf.php");
require("../html_table.php");
include("../user/session.php");
$student_mat='13sl13';//$_SESSION['nr_matricol'];

$servername="localhost";
$username="serb_costa";
$db_pass="pass";
$DB="TW_database";

$connection= new mysqli($servername,$username,$db_pass,$DB);

$prognosix_points_query="SELECT nume_obiect, punctaj from punctaje where student_matricola=?";

$prognosix_points_query=$connection->prepare($prognosix_points_query);

$prognosix_points_query->bind_param("s",$student_mat);

$prognosix_points_query->execute();


$meta=$prognosix_points_query->result_metadata();


while ($field = $meta->fetch_field())
{
    $params[] = & $row[$field->name];
}

call_user_func_array(array($prognosix_points_query, 'bind_result'), $params);

while ($prognosix_points_query->fetch())
{

    foreach($row as $key => $val)

    {

        $c[$key] = $val;

    }

    $result[] = $c;

}

mysqli_close($connection);

$csv_file_name="../temporary_files/prognosix_".$_SESSION['nr_matricol'].".csv";
$pdf_file_name="../temporary_files/prognosix_".$_SESSION['nr_matricol'].".pdf";

$csv_file=fopen($csv_file_name,'w');

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);

$pdf->SetX(65);
$pdf->MultiCell(70,8 , "Punctaje PrognosiX - ".ucfirst($_SESSION['nume'])." ".ucfirst($_SESSION['prenume']),1 ,'C');

foreach($result as $row){

    $csv_line=array($row['nume_obiect'],$row['punctaj']);
   // $pdf_line=strtoupper($row['nume_obiect'])." :              ".$row['punctaj'];
   // $pdf->MultiCell(70,8 , $pdf_line,1 ,'L');
    $pdf->SetX(65);
    $pdf->Cell(55,5,strtoupper($row['nume_obiect']),1,0,'C',0);

    $pdf->Cell(15,5,$row['punctaj'],1,0,'C',0);
    $pdf->Ln();

    fputcsv($csv_file, $csv_line);

}

fclose($csv_file);

$pdf->Output($pdf_file_name,'F');

$zip = new ZipArchive;
$zipname='../temporary_files/prognosix_'.$_SESSION['nr_matricol'].'.zip';

if ($zip->open($zipname,  ZipArchive::CREATE)) {
    $zip->addFile($csv_file_name, 'prognosix_punctaj.csv');
    $zip->addFile($pdf_file_name, 'prognosix_punctaj.pdf');
    $zip->close();

    echo 'Archive created!';
    unlink($csv_file_name);
    unlink($pdf_file_name);

    header('Content-disposition: attachment; filename=punctaje_prognosix.zip');
    header('Content-type: application/zip');
    header("Content-length: " . filesize($zipname));
    readfile($zipname);
    unlink($zipname);
}

else {

    echo 'Failed!';

}
