<?php
include_once('../include/webzone.php');
unset($_SESSION['access_token']);
unset($_SESSION['twt_box']);
header('Location: ../index.php');
?>