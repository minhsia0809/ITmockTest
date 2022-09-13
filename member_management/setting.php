<?php

include("../utility_functions.php");
role_require(2);

$con=db_link();

switch(true)
{
	case(isset($_GET["change_role"])):

		$role=$_POST["role"];
		$identity=$_POST["identity"];

		mysqli_query($con, "UPDATE user SET role='$role' WHERE identity='$identity'");

		break;

	case(isset($_GET["delete"])):

		$identity=$_POST["identity"];

		mysqli_query($con, "DELETE FROM user WHERE identity='$identity'");

		break;
}

header("location: list.php");

?>