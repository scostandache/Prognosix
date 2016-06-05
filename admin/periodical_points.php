<?php
ini_set("display_errors", 0);

$today=date('Y-m-d');


/*$time1 = strtotime('04-06-2016');
$newformat1 = date('d-m-Y',$time1);

$time2 = strtotime('10-06-2016');
$newformat2 = date('d-m-Y',$time2);


$semester_dates=[

     $newformat1=>false,
     $newformat2=>false

];*/
$servername="localhost";
$username="serb_costa";
$db_pass="pass";
$DB="TW_database";
$connection= new mysqli($servername,$username,$db_pass,$DB);

$dates_query="select students_announced from Periodical_announces where announce_date=?";
$dates_query=$connection->prepare($dates_query);
$dates_query->bind_param("s",$today );
$dates_query->execute();
$dates_query->bind_result( $announced);
$dates_query->fetch();

mysqli_close($connection);


if( $announced==0){
    $connection= new mysqli($servername,$username,$db_pass,$DB);

    $grades_query="select student_matricola, luata,ghicita, nume_obiect from note inner join ".
        "evenimente on note.examen_id=evenimente.examen_id inner join ".
        "examene on note.examen_id=examene.id_exam where data_rezultate<CURRENT_DATE";

    $students_grades = $connection->query($grades_query);

    mysqli_close($connection);


    while($row=$students_grades->fetch_assoc()){

        if($row["luata"]!=$row["ghicita"]){
            $object_name=$row["nume_obiect"];
            $matricola_student=$row["student_matricola"];

            $update_points_query="UPDATE punctaje set punctaj=punctaj+1 where student_matricola=? and nume_obiect= ?";

            $update_points_query=$connection->prepare($update_points_query);
            $update_points_query->bind_param("ss",$matricola_student,$object_name );

            

            $connection= new mysqli($servername,$username,$db_pass,$DB);



        }





    }

}

