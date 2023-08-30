<?php
session_start();
$_SESSION['ownerId'] = "";
$_SESSION['ownerUser'] = "";
session_destroy();
header("Location:cp_login.php");
?>
