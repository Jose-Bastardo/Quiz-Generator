<?php

    $answergiven = $_POST["options"];
    $check = "0";

    if("optionc" == $answergiven){
        $check = "1";
        echo $check;
    }
    else if($answergiven == NULL){
        $check = "-1";
        echo $check;
    }
    else{
        echo $check.",".$answergiven;
    }
?>