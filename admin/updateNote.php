<?php

    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "dbtw";
    $file = basename($_FILES["fileToUpload"]["name"]);
    $typeFile = pathinfo($file, PATHINFO_EXTENSION);

    //$xml2 = simplexml_load_file($_FILES['fileToUpload']['tmp_name']);
    //print_r(count($xml2));

    if($typeFile != "xml"){
        echo "This file is not a XML." . "<br>";
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

        for ($i = 0; $i < count($xml); $i++) {

            $query = "UPDATE note
                  SET luata=" . $xml->student[$i]->nota .
                " WHERE student_matricola =" . $xml->student[$i]->matricola . " and " . "examen_id =" . $xml->student[$i]->examenid;
            if ($connection->query($query) === FALSE) {
                echo "Fail grades upload: " . $connection->error;
            }
            //echo "matricola:" . $xml->student[$i]->matricola . " obiect:" . $xml->student[$i]->obiect . " nota:" . $xml->student[$i]->nota . "<br>";

        }
        
        









        echo "Succesfully grades upload.";
        mysqli_close($connection);
    }
?>