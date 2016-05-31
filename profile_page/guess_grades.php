<?php
//http://stackoverflow.com/questions/24363755/mysqli-bind-results-to-an-array
$servername="localhost";
$username="serb_costa";
$db_pass="pass";
$DB="TW_database";
$conn= new mysqli($servername,$username,$db_pass,$DB);

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}

$stmt= $conn->prepare("select examene.nume_obiect,examene.tip,examene.id_exam ".

    "from examene  ".

    "inner join evenimente on examene.id_exam=evenimente.examen_id ".

    "inner join note on examene.id_exam = note.examen_id ".

    "where  note.student_matricola = ? ".

    "and  evenimente.data_examen <= CURRENT_DATE() ".

    "and evenimente.data_rezultate >=CURRENT_DATE() ".

    "and note.ghicita is NULL" );


$nr_matricol=$_SESSION['nr_matricol'];


$stmt->bind_param('s', $nr_matricol);

$stmt->execute();

$meta = $stmt->result_metadata();

$meta = $stmt->result_metadata();

while ($field = $meta->fetch_field())
{
    $params[] = & $row[$field->name];
}

call_user_func_array(array($stmt, 'bind_result'), $params);



while ($stmt->fetch()) {

    foreach($row as $key => $val)

    {

        $c[$key] = $val;

    }

    $result[] = $c;

}

$stmt->close();

$conn->close();

if (sizeof($result) > 0) {
    foreach ($result as $result_line) {

        echo "
            <form action='set_grade.php?exam=" . $result_line['id_exam'] . "' method='post'>
                
                <div class='form_name'>
                
                    <span id='exam_name' >  " . ucfirst($result_line['nume_obiect']) . " </span>
                    <span id='exam_type' > ( " . ucfirst($result_line['tip']) . " )</span>
                
                </div>
                <div class='grade_submit' >
                  
                    <input type = 'number' value = '1' name ='guessed_grade' min='1' max ='10' >
                    <input type = 'submit' >
                
                </div>
                           
                           
             </form>
     
    ";

    }
}
?>