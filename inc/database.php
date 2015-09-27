<?php
/**
* File: database.php
* 
* Check whether can connect to PhpMyAdmin and find the particular Database. 
* @author Lim Zheng Siang
* @version 1.0.0
*/

    $dbConnect = @mysql_connect($dbHost, $dbUser, $dbPassword) or die ("<p style='text-align:center;color:red;'>Database connection failed!</p>");
   
    $dbSelected = @mysql_select_db($dbName, $dbConnect) or die ("<p style='text-align:center;color:red;'>Unable to find the database!</p>");

?>
