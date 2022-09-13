<?php

setcookie("member_ID", "", time()-1, "/itmocktest/");
header("location: /itmocktest/homepage.php");

?>