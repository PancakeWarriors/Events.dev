<?php

try
{
	$connect = new PDO("mysql:host=127.0.0.1;dbname=events_db",'events_user','password');
}
catch(Exception $e)
{
	die("Error".$e->getMessage());
}



?>