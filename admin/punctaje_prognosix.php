<?php
ini_set("display_errors", 0);
require ("../fpdf181/fpdf.php");
require("../html_table.php");

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
$pdf->MultiCell(70,8 , "Punctaje PrognosiX",1 ,'C');

foreach($result as $row){


    $csv_line=array($row['nume_obiect'],$row['punctaj']);
    $pdf_line=strtoupper($row['nume_obiect'])." ".$row['punctaj'];

    $pdf->MultiCell(70,8 , $pdf_line,1 ,'C');

    fputcsv($csv_file, $csv_line);

}

fclose($csv_file);

$pdf->Output($pdf_file_name,'F');
$zip=new ZipArchive();
