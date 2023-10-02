<?php
if (isset($_SESSION['UserPrivilege']) && isset($_SESSION['SessionToken']) && isset($_SESSION['codeBit'])) { }else{ header("Location: process/logout.php"); exit(); }