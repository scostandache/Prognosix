<?php
ini_set("display_errors", 0);

$today=date('d-m-Y');


$time1 = strtotime('04-06-2016');
$newformat1 = date('d-m-Y',$time1);

$time2 = strtotime('10-06-2016');
$newformat2 = date('d-m-Y',$time2);


$semester_dates=[

     $newformat1=>"false",
     $newformat2=>"false"

];

if( false == $newformat1[$today] ){





}

