<?php
session_start();
session_destroy();
header("Location: ../Beranda.php");
exit();
