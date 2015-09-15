<?php

try
{
	$connect = new PDO("mysql:host=127.0.0.1;dbname=events_db",'events_db_user','');
}
catch(Exception $e)
{
	die("Error".$e->getMessage());
}



?>