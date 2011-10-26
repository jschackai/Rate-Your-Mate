<?php
    /*
    * This file is to hold all the constants - 'variables' that we use over and over and never change.
    */
    
    ini_set("display_errors", true);//turn off for live!
    error_reporting(-1);//turn off for live!
    date_default_timezone_set ("America/New_York");
    //databse info
    define( "DB_DSN", "mysql:host=localhost;dbname=tincanwe_rym" );
    define('DB_USER', 'tincanwe_rym');
    define('DB_PASS', 'pAlh3ccaeghQOq1aqH07');
    define('DB_ERR', 'We appear to be having database issues, please bear with us and try again.');
    //persistant connection?
    try {
        $dbh = new PDO(DB_DSN,DB_USER,DB_PASS);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
        die("Unable to connect. $e");
    }
?>