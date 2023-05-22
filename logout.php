<?php

session_start();

if (isset($_SESSION["login"])) {
    $_SESSION["login"] = false;
}
header("Location: ./bloc.php");
exit();

?>