<?php
session_start();
if(session_destroy())
{
header("Location: crs003s.php");

}



?>