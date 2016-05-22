<?php

/*$nume=$_SESSION['nume'];
$prenume=$_SESSION['prenume'];
$grupa=$_SESSION['grupa'];
$email=$_SESSION['email'];
$nr_matricol=$_SESSION['matricola'];
*/
$nume="costandache";
$prenume="valeriu";
$grupa="3A2";
$email="valeriuv.costandache@info.uaic.ro";
$nr_matricol="13sl13";

echo
"<ul class=\"student_informations_list\">

                  <li>Nume:".ucfirst($nume)." </li>
                  <li>Prenume:".ucfirst($prenume)." </li>
                  <li>Grupa:".$grupa." </li>
                  <li>E-mail:".$email." </li>
                  <li>Nr. matricol:".$nr_matricol." </li>

</ul>";

?>