<?php
$dbserver = "localhost";
$dbname = "site_db";
$username = "root";
$password = "1234";
$db = mysqli_connect($dbserver, $username, $password, $dbname) or die ("DB connection error " . mysqli_error($db));
