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

/*$dates_query="select students_announced from Periodical_announces where announce_date=?";
$dates_query=$connection->prepare($dates_query);
$dates_query->bind_param("s",$today );
$dates_query->execute();
$dates_query->bind_result( $announced);
$dates_query->fetch();
*/


$dates_query="select * from anunturi_periodice";
$dates_resulted=$connection->query($dates_query);

$row1=$dates_resulted->fetch_array();
$row2=$dates_resulted->fetch_array();

mysqli_close($connection);


if( $today==$row1[0] && $row1[1]==0){ // anuntul cu punctaje pentru jumatatea semestrului

    echo "hello";
    $connection= new mysqli($servername,$username,$db_pass,$DB);

    $grades_query="select student_matricola, luata,ghicita, nume_obiect from note inner join ".
        "evenimente on note.examen_id=evenimente.examen_id inner join ".
        "examene on note.examen_id=examene.id_exam where data_rezultate < CURRENT_DATE";

    $students_grades = $connection->query($grades_query);

    mysqli_close($connection);


    while($row=$students_grades->fetch_assoc()){

        if($row["luata"]!=$row["ghicita"]){
            $object_name=$row["nume_obiect"];
            $matricola_student=$row["student_matricola"];

            $update_points_query="UPDATE punctaje set punctaj=punctaj-1 where student_matricola=? and nume_obiect= ?";

            $connection= new mysqli($servername,$username,$db_pass,$DB);

            $update_points_query=$connection->prepare($update_points_query);
            $update_points_query->bind_param("ss",$matricola_student,$object_name );

            $update_points_query->execute();

            mysqli_close($connection);

        }
        else
            if($row["luata"]==$row["ghicita"]){
                $object_name=$row["nume_obiect"];
                $matricola_student=$row["student_matricola"];
                echo $matricola_student;
                echo $object_name;
                $update_points_query="UPDATE punctaje set punctaj=punctaj+2 where student_matricola=? and nume_obiect= ?";

                $connection= new mysqli($servername,$username,$db_pass,$DB);

                $update_points_query=$connection->prepare($update_points_query);
                $update_points_query->bind_param("ss",$matricola_student,$object_name );

                $update_points_query->execute();

                mysqli_close($connection);

            }

    }

    $row1[1]=1;
    
    $connection= new mysqli($servername,$username,$db_pass,$DB);
    $update_announced="UPDATE anunturi_periodice set students_announced = 1 where announce_date =?";
    $update_announced=$connection->prepare($update_announced);
    $update_announced->bind_param("s",$today );
    $update_announced->execute();
    mysqli_close($connection);

    $update_title="Punctaje partiale PrognosiX";
    $category='ALL';
    $update_text="<![CDATA[ <a href='punctaje_prognosix.php'> Aici </a>]]> poti vedea punctajele partiale PrognosiX, in functie de fiecare obiect.";
    
    
    $connection= new mysqli($servername,$username,$db_pass,$DB);
    $sql_report=$connection->prepare("INSERT into reports(TITLE,CATEGORY,CONTENT,POSTED) VALUES (?,?,?,NOW())");
    $sql_report->bind_param('sss',$update_title,$category,$update_text );
    $sql_report->execute();

    mysqli_close($connection);

   //$announced=1; update database;
}

elseif($today==$row2[0] && $row2[1]==0){

    $connection= new mysqli($servername,$username,$db_pass,$DB);

    $grades_query="select student_matricola, luata,ghicita, nume_obiect from note inner join ".
        "evenimente on note.examen_id=evenimente.examen_id inner join ".
        "examene on note.examen_id=examene.id_exam where data_rezultate>=? and data_rezultate <= ?";

    $grades_query=$connection->prepare($grades_query);
    $grades_query->bind_param("ss",$row1[0],$row2[0] );
    $grades_query->execute();

    $meta=$grades_query->result_metadata();

    while ($field = $meta->fetch_field())
    {
        $params[] = & $row[$field->name];
    }

    call_user_func_array(array($grades_query, 'bind_result'), $params);
    
    while ($grades_query->fetch()) {

        foreach($row as $key => $val)

        {

            $c[$key] = $val;

        }

        $result[] = $c;

    }

    mysqli_close($connection);

    foreach($result as $row){
        echo $row['luata'];

        if($row["luata"]!=$row["ghicita"]){
            $object_name=$row["nume_obiect"];
            $matricola_student=$row["student_matricola"];

            $update_points_query="UPDATE punctaje set punctaj=punctaj-1 where student_matricola=? and nume_obiect= ?";

            $connection= new mysqli($servername,$username,$db_pass,$DB);

            $update_points_query=$connection->prepare($update_points_query);
            $update_points_query->bind_param("ss",$matricola_student,$object_name );

            $update_points_query->execute();

            mysqli_close($connection);

        }
        else
            if($row["luata"]==$row["ghicita"]){
                $object_name=$row["nume_obiect"];
                $matricola_student=$row["student_matricola"];
                echo $matricola_student;
                echo $object_name;
                $update_points_query="UPDATE punctaje set punctaj=punctaj+2 where student_matricola=? and nume_obiect= ?";

                $connection= new mysqli($servername,$username,$db_pass,$DB);

                $update_points_query=$connection->prepare($update_points_query);
                $update_points_query->bind_param("ss",$matricola_student,$object_name );

                $update_points_query->execute();

                mysqli_close($connection);

            }

    }

    $row2[1]=1;

    $connection= new mysqli($servername,$username,$db_pass,$DB);
    $update_announced="UPDATE anunturi_periodice set students_announced = 1 where announce_date =?";
    $update_announced=$connection->prepare($update_announced);
    $update_announced->bind_param("s",$today );
    $update_announced->execute();
    mysqli_close($connection);

    $update_title="Punctaje finale PrognosiX";
    $category='ALL';
    $update_text="<![CDATA[ <a href='punctaje_prognosix.php'> Aici </a>]]> poti vedea punctajele finale PrognosiX, in functie de fiecare obiect.";


    $connection= new mysqli($servername,$username,$db_pass,$DB);
    $sql_report=$connection->prepare("INSERT into reports(TITLE,CATEGORY,CONTENT,POSTED) VALUES (?,?,?,NOW())");
    $sql_report->bind_param('sss',$update_title,$category,$update_text );
    $sql_report->execute();

    mysqli_close($connection);
    
    
    
    
    
}

