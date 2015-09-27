<?php
session_start();

if(session_destroy())
{
header("Location: index3.php");

}
?>