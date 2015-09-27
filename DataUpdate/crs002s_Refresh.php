<?php
session_start();
if(session_destroy())
{
	header("Location: crs002s.php");

}

?>