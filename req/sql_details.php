<?php
    $db_hostname = 'localhost';
    $db_database = 'sommarmobler';
    $db_username = 'root';
    $db_password = 'Ultarekar123';

    function clean_string($connection, $string)
    {
        return htmlentities(mysql_fix_string($connection, $string));
    }

    function mysql_fix_string($connection, $string)
    {
        if (get_magic_quotes_gpc()) $string = stripslashes($string);
        return $connection->real_escape_string($string);
    }
?>