<?php
$file_name=$_GET["to_dwnd"];

header("Content-type: text/csv");
header("Content-disposition: attachment; filename = $file_name");

readfile("file_export/$file_name");
