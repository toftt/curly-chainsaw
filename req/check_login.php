<?php
    session_start();

    if (!(isset($_SESSION['username']) && $_SESSION['check'] ==
        hash('ripemd128', $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'])))
    {
        header('Location: fyranollfyra.php');
        exit();
    }
    
    else
    {
        $username = $_SESSION['username'];
    }
?>