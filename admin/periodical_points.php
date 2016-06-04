<?php
ini_set("display_errors", 0);

$today=date('d-m-Y');


$time1 = strtotime('04-06-2016');
$newformat1 = date('d-m-Y',$time1);

$time2 = strtotime('10-06-2016');
$newformat2 = date('d-m-Y',$time2);


$semester_dates=[

     $newformat1=>false,
     $newformat2=>false

];


if( false == $semester_dates[$today] ){

    echo "today";
    $servername = "localhost";
    $username = "serb_costa";
    $password = "pass";
    $dbname = "TW_database";

    $grades_query="select student_matricola, luata,ghicita, nume_obiect from note inner join ".
        "evenimente on note.examen_id=evenimente.examen_id inner join ".
        "examene on note.examen_id=examene.id_exam where data_rezultate<CURRENT_DATE";

    $connection = new mysqli($servername, $username, $password, $dbname);
    $result = $connection->query($grades_query);






}

