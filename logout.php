<?php
session_start();
session_unset();
session_destroy();
header("Location: /reg_otp/index.php");
?>