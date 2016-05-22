<?php
include("../user/session.php");
$servername="localhost";
$username="serb_costa";
$pass="pass";
$DB="TW_database";
$conn= new mysqli($servername,$username,$pass,$DB);

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}


$nr_matricol=$_SESSION['nr_matricol'];

$sql_student_objects_query="select DISTINCT examene.nume_obiect FROM note INNER JOIN examene ON note.examen_id = examene.id_exam where note.student_matricola=?";
$student_info_query=$conn->prepare($sql_student_objects_query);
$student_info_query->bind_param("s",$nr_matricol );
$student_info_query->execute();
$objects_result=$student_info_query->get_result();

echo "<table>

    <tr>
        <td>Obiect</td>
        <td>Laborator</td>
        <td>Proiect</td>
        <td>Examen</td>
    </tr>";

$exam_types=array("laborator","proiect","examen");

while($object=$objects_result->fetch_array()){

    echo "<tr>";
    $object_name=$object['nume_obiect'];

        echo "<td>".$object_name."</td>";

        foreach($exam_types as $type){

             $conn2= new mysqli($servername,$username,$pass,$DB);
             $sql_object_grades_query="SELECT note.luata FROM note INNER JOIN examene ON note.examen_id = examene.id_exam WHERE note.student_matricola = ? AND examene.nume_obiect = ? AND examene.tip = ?";
             $object_grades_query=$conn2->prepare($sql_object_grades_query);

             $object_grades_query->bind_param('sss',$nr_matricol,$object_name,$type);

             $object_grades_query->execute();
             $object_grades_query->bind_result($exam_grade);
             $object_grades_query->fetch();
             echo "<td>".$exam_grade."</td>";

        }

    echo"</tr>";
}

echo"</table>"

?>