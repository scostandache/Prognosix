<?php
ini_set("display_errors", 0);//ascunde warning-urile
$servername = "localhost";
$username = "serb_costa";
$password = "pass";
$dbname = "TW_database";

$obiect = strtolower ($_POST[obiect]);
$tip = strtolower ($_POST[tip]);
$grupa = strtoupper ($_POST[grupa]);
$dataInceput = $_POST[inceput];
$dataSfarsit = $_POST[sfarsit];

if(strlen($obiect) == 0 || strlen($tip) == 0 || strlen($dataInceput) == 0 || strlen($dataSfarsit) == 0){
    echo "Not all required information." . "<br>";
}
else
{
    if ($tip != "examen" and $tip != "laborator" and $tip != "proiect") {
        echo "Tipul trebuie sa fie examen, laborator sau proiect.";
    }
    else
    {
        if (DateTime::createFromFormat('d-m-Y', $dataInceput) == FALSE || DateTime::createFromFormat('d-m-Y', $dataSfarsit) == FALSE) {
            echo "Invalid date." . "<br>";
        } else {
            $connection = new mysqli($servername, $username, $password, $dbname);

            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            }
            $sql = "SELECT id_exam FROM examene WHERE nume_obiect = '" . $obiect . "' and tip = '" . $tip . "' and grupa = '" . $grupa . "'";
            //echo $sql;

            $result = $connection->query($sql);
            $row = $result->fetch_assoc();
            $id_exam = $row["id_exam"];

            if (strlen($id_exam) == 0) {
                $insertStm  = $connection->prepare("INSERT INTO examene(nume_obiect, tip, grupa) VALUES (?, ?, ?)");
                $insertStm->bind_param("sss", $obiect, $tip, $grupa);
                if ($insertStm->execute() == FALSE){
                    echo "Fail insert event " . $insertStm->error. "<br>";
                }
                else {
                   // echo "Insert obiect." . "<br>";
                }
                // $sqlInsert = "INSERT INTO examene(nume_obiect, tip, grupa)
                //             VALUES ('". $obiect . "','" . $tip . "','" . $grupa. "')";
                //if ($connection->query($sqlInsert) === FALSE) {
                // echo "Fail insert exam. " . $connection->error . "<br>";
                //}
                mysqli_stmt_close($insertStm);
                $sql = "SELECT id_exam FROM examene WHERE nume_obiect = '" . $obiect . "' and tip = '" . $tip . "' and grupa = '" . $grupa . "'";
                $result = $connection->query($sql);
                $row = $result->fetch_assoc();
                $id_exam = $row["id_exam"];
            }

            $sql2 = "SELECT count(id_ev) FROM evenimente WHERE data_examen =STR_TO_DATE('" . $dataInceput . "', '%d-%m-%Y') and data_rezultate=STR_TO_DATE('" . $dataSfarsit . "', '%d-%m-%Y') and examen_id = " . $id_exam;
            //echo $sql2;
            $result2 = $connection->query($sql2);
            $row2 = $result2->fetch_assoc();
            //echo $row2["count(id_ev)"];
            if ($row2["count(id_ev)"] > 0) {
                echo "Evenimentul este deja creat !" . "<br>";
                header('refresh:1;url=admin_dash.php');
            }
            else
            {
                /*$sqlInsert = "INSERT INTO evenimente(data_examen, data_rezultate, examen_id)
                VALUES (STR_TO_DATE('" . $dataInceput . "', '%d-%m-%Y'), STR_TO_DATE('" . $dataSfarsit . "', '%d-%m-%Y'), " . $id_exam . ")";
                if ($connection->query($sqlInsert) === FALSE) {
                    echo "Fail insert event " . $connection->error . "<br>";
                }
                else
                {
                    echo "Succesfully insert event." . "<br>";
                }*/
                $insertStm  = $connection->prepare("INSERT INTO evenimente(data_examen, data_rezultate, examen_id)
                                  VALUES (STR_TO_DATE(?, '%d-%m-%Y'), STR_TO_DATE(?, '%d-%m-%Y'), ?)");
                $insertStm->bind_param("ssi", $dataInceput, $dataSfarsit, $id_exam);
                if ($insertStm->execute() == FALSE){
                    echo "Fail insert event " . $insertStm->error. "<br>";
                }
                else{
                   // echo "Succesfully insert event." . "<br>";
                }
                mysqli_stmt_close($insertStm);

                $sql = "SELECT grupa FROM examene WHERE nume_obiect = '" . $obiect . "' and tip = '" . $tip . "'";
                $result = $connection->query($sql);
                $row = $result->fetch_assoc();
                $grupa = $row["grupa"];
                //echo $grupa;

                $insertStm  = $connection->prepare("INSERT INTO note(luata, ghicita, student_matricola, examen_id)
                                            VALUES (NULL, NULL, ?, ?)");

                $count = 0;
                if ($tip == "examen") {
                    $sql = "SELECT matricola from studenti WHERE grupa LIKE '" . $grupa[0] . "%'";
                    $result = $connection->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        $ok = 1;
                        $matricola = $row["matricola"];

                        $sql2 = "select count(student_matricola) from note where student_matricola ='" . $matricola . "' and " . "examen_id=" . $id_exam;
                        $result2 = $connection->query($sql2);
                        $row2 = $result2->fetch_assoc();
                        if ($row2["count(student_matricola)"] != 0) {
                            $ok = 0;
                        }
                        if ($ok == 1) {
                            //$sqlInsert2 = $sqlInsert2 . "INSERT INTO note(luata, ghicita, student_matricola, examen_id)
                            //             VALUES (NULL, NULL, " . $matricola . ", " . $id_exam . ");";

                            $insertStm->bind_param("si", $matricola, $id_exam);
                            if ($insertStm->execute() == FALSE){
                                echo "Fail insert event " . $insertStm->error. "<br>";
                            }
                            else{
                                //echo "Succesfully insert for grades." . "<br>";
                                $cont++;
                            }
                        }
                    }
                   // echo "Succesfully insert for grades (" . $cont ." lines).";
                    //echo $sqlInsert2;
                    /*if ($connection->multi_query($sqlInsert2) === FALSE) {
                        echo "Fail insert for grades." . $connection->error . "<br>";
                    } else {
                        echo "Succesfully insert for grades." . "<br>";
                    }*/
                } else {
                    $sql = "SELECT matricola from studenti WHERE grupa = '" . $grupa . "'";
                    $result = $connection->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        $ok = 1;
                        $matricola = $row["matricola"];

                        $sql2 = "select count(student_matricola) from note where student_matricola ='" . $matricola . "' and " . "examen_id=" . $id_exam;
                        $result2 = $connection->query($sql2);
                        $row2 = $result2->fetch_assoc();
                        if ($row2["count(student_matricola)"] != 0) {
                            $ok = 0;
                        }

                        if ($ok == 1) {
                            //$sqlInsert2 = $sqlInsert2 . "INSERT INTO note(luata, ghicita, student_matricola, examen_id)
                            //VALUES (NULL, NULL, " . $matricola . ", " . $id_exam . ");";
                            $insertStm->bind_param("si", $matricola, $id_exam);
                            if ($insertStm->execute() == FALSE){
                                echo "Fail insert event " . $insertStm->error. "<br>";
                            }
                            else{

                                $cont++;
                            }
                        }
                    }
                   // echo "Succesfully insert for grades (" . $cont ." lines).";
                    //echo $sqlInsert2;
                    /*if ($connection->multi_query($sqlInsert2) === FALSE) {
                        echo "Fail insert for grades." . $connection->error . "<br>";
                    } else {
                        echo "Succesfully insert for grades." . "<br>";
                    }*/
                }
                mysqli_stmt_close($insertStm);

                $connection2 = new mysqli($servername, $username, $password, $dbname);
                $insertStm  = $connection2->prepare("INSERT INTO punctaje(nume_obiect, punctaj, student_matricola)
                                            VALUES (?, ?, ?)");

                $sql = "SELECT matricola from studenti WHERE grupa LIKE '" . $grupa[0] . "%'";

                $result = $connection2->query($sql);
                $cont = 0;
                while ($row = $result->fetch_assoc()) {
                    $ok = 1;
                    $matricola = $row["matricola"];
                    //echo $obiect . "-->" . $matricola . "--> 0 pt toti." . "<br>";

                    $sql2 = "select count(*) from punctaje where nume_obiect ='" . $obiect . "' and student_matricola = '" . $matricola . "'";
                    //echo $sql2;
                    $result2 = $connection2->query($sql2);
                    $row2 = $result2->fetch_assoc();
                    //echo $row2["count(*)"];
                    if ($row2["count(*)"] == 0) {
                        $ok = 0;
                    }
                    if($ok == 0) {
                        $insertStm->bind_param("sis", $obiect, $ok, $matricola);
                        if ($insertStm->execute() == FALSE) {
                            echo "Fail insert event " . $insertStm->error . "<br>";
                        } else {
                            //echo "Succesfully insert for grades." . "<br>";
                            $cont++;
                        }
                    }
                }
                mysqli_stmt_close($insertStm);
              //  echo "Succesfully insert for points (" . $cont ." lines)." . "<br>";
                mysqli_close($connection2);

            }
            mysqli_close($connection);
        }
        echo "Examen introdus in baza de date !" . "<br>";
        header('refresh:1;url=admin_dash.php');}
}
?>