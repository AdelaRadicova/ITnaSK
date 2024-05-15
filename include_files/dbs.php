<?php

function connectDbs(): mysqli
{
    //connection to the database
    $dbServername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "it_na_sk";

    return new mysqli($dbServername,$dbUsername,$dbPassword,$dbName);
}
