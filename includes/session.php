<?php
    session_start();

    if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] === true){
        header("location: user-index.php");
        exit;
    }
?>