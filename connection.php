<?php
    // serwer
    $mysql_server = "mysql.cba.pl";
    // admin
    $mysql_admin = "UpadekSQL";
    // hasło
    $mysql_pass = "Konie@12";
    // nazwa baza
    $mysql_db = "upadek";
    // nawiązujemy połączenie z serwerem MySQL
	$conn = new mysqli($mysql_server, $mysql_admin, $mysql_pass, $mysql_db);
    $conn->set_charset("utf8");
	
    if($conn->connect_errno!=0){ #połączenie nieudane
        echo "Error: ".$conn->connect_errno;
        exit();
    }
?>

