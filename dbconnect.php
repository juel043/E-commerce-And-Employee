<?php

	 $DBhost = "localhost";
	 $DBuser = "root";
	 $DBpass = "";
	 $DBname = "e-commerce";
	 
	 $DB_con = new MySQLi($DBhost,$DBuser,$DBpass,$DBname);
    
     if ($DB_con->connect_errno) 
     {
         die("ERROR : -> ".$DB_con->connect_error);
     }
?>