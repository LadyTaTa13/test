<?php
$x = '[{"fname":"ui","lname":"chuam"},{"fname":"yay","lname":"too"}]';
echo $x;

$y= json_decode($x,TRUE);
//echo $y[1]->fname;
//echo $y;
echo $y[1]["fname"];

$z =array(
        array("fname"=>"ta","lname"=>"chuam"),
        array("fname"=>"yay","lname"=>"too"),
        array("fname"=>"ka","lname"=>"yee")
        );
        echo "<pre>";
        print_r($z);
        echo "</pre>";
     $a=  json_encode($z);
     echo $a;

?>