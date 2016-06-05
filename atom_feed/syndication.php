<?php
error_reporting(E_ERROR);
function date3339($timestamp=0) {
    if (!$timestamp) {
        $timestamp = time();
    }

    $date = date('Y-m-d\TH:i:s', $timestamp);

    $matches = array();
    if (preg_match('/^([\-+])(\d{2})(\d{2})$/', date('O', $timestamp), $matches)) {
        $date .= $matches[1].$matches[2].':'.$matches[3];
    } else {
        $date .= 'Z';
    }

    return $date;
}

header('Content-type: text/xml');

$servername = "localhost";
$username = "serb_costa";
$password = "pass";
$dbname = "TW_database";

$connection = new mysqli($servername, $username, $password, $dbname);

$feed_query="SELECT id,title,category,content,posted from reports";
$result = $connection->query($feed_query);
mysqli_close($connection);
echo "<?xml version='1.0' encoding='iso-8859-1' ?>";
?>

<feed xml:lang="en-US" xmlns="http://www.w3.org/2005/Atom">
    <title>Feed afisare punctaje</title>
    <subtitle>Aici sunt afisate schimbarile de situatii</subtitle>
    <link href="http://localhost/Prognosix/atom_feed" rel="self"/>
    <updated><?php echo date3339(); ?></updated>
    <id>http://localhost/Prognosix/atom_feed/syndication.php</id>

    <?php

        $i=0;
        while($row=mysqli_fetch_array($result)){
            if ($i > 0) {
                echo "</entry>";
            }
        $report_date=$row['posted'];
        echo "<entry>";
        echo "<title>";
        echo $row['title'];
        echo "</title>";
        echo "<id>";
        echo $row['id'];
        echo"</id>";
        echo"<updated>";
        echo $row['posted'];
        echo"</updated>";
        $label=$row['category'];
        echo"<category term='$label'>";
        echo "</category>";
        echo "<content>";
        echo $row['content'];
        echo "</content>";
        $i++;
    }
    ?>
   </entry>
</feed>