<?php

include("../utility_functions.php");
role_require(1);

$con=db_link();

switch(true)
{
	case(isset($_GET["add"])):

		$no=$_POST["no"];
		$question=$_POST["question"];
		$A=$_POST["A"];
		$B=$_POST["B"];
		$C=$_POST["C"];
		$D=$_POST["D"];
		$answer=$_POST["answer"];

		$question_db_name=question_db_name($_POST["type"]);

		$result=mysqli_query($con, "INSERT INTO $question_db_name[0](no, question, A, B, C, D, answer) VALUES('$no', '$question', '$A', '$B', '$C', '$D', '$answer')");

		break;

	case(isset($_GET["edit"])):

		$no=$_POST["no"];
		$question=$_POST["question"];
		$A=$_POST["A"];
		$B=$_POST["B"];
		$C=$_POST["C"];
		$D=$_POST["D"];
		$answer=$_POST["answer"];

		$question_db_name=question_db_name($_POST["type"]);

		mysqli_query($con, "UPDATE $question_db_name[0] SET question='$question', A='$A', B='$B', C='$C', D='$D', answer='$answer' WHERE no='$no'");

		break;

	case(isset($_GET["delete"])):

		$no=$_POST["no"];

		$question_db_name=question_db_name($_POST["type"]);

		mysqli_query($con, "DELETE FROM $question_db_name[0] WHERE no='$no'");

		break;
}

header("location: show.php?type=".$_POST["type"]."&page=".$_POST["page"]);

?>