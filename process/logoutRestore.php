<?php
include '../library/configServer.php';
include '../library/consulSQL.php';
session_start();
session_unset();
session_destroy();
header("Location: ../index.php"); 