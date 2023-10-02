<?php
if ($_SESSION['UserPrivilege']=='Admin' && isset($_SESSION['SessionToken']) && isset($_SESSION['codeBit'])) { }else{ header("Location: ../process/logout.php"); exit(); }