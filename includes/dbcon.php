
<?php
$serverName = "LAPTOP-S8SF7R0T\SQLEXPRESS";
$connectionInfo = array("Database" => "investment_db", "UID" => "sa", "PWD" => "123456", "CharacterSet" => "UTF-8");
$Con = sqlsrv_connect($serverName, $connectionInfo);

if ($Con) {
    /*echo "connection established.<br />";*/
} else {
    echo "connection could not be established.<br />";
    die(print_r(sqlsrv_errors(), true));
}
