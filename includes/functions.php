<?php
    /*
    * This file is to hold commonly-used functions.
    */

    function getGuid(){
        return $guid=(function_exists('com_create_guid') === true)? trim(com_create_guid(), '{}'):sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

?>