<!DOCTYPE html>
<?php

include("../DatabaseConnect.php");
session_start();
echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
?>