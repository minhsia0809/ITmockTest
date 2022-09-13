<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<link rel="icon" href="/itmocktest/image/logo.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link href="des.css" rel="stylesheet" type="text/css">

	<?php include("utility_functions.php"); ?>
	<?php top_menu(); ?>

	<title>資訊能力檢定模擬測驗</title>
</head>

<body>

	<div class="padding">

		<h2 align="center" style="font-weight: bold;">資訊能力檢定模擬測驗</h2>
		<h4 align="center" style="padding-bottom: 32px;">協助您在考試前多加磨練&emsp;敬祝各位考試順利</h4>

		<?php

		echo "<center>";

		if(isset($_COOKIE["member_ID"]))
			echo "<button class='primary' onclick='javascript:location.href=\"choose.php\"'>開始測驗</button>";
		else
			echo "<button href='/itmocktest/modal/login.php' class='primary' data-toggle='modal' data-target='#login'>開始測驗</button>";
		echo "</center>";

		$con=db_link();
		srand(floor((time()+28800)/86400));

		$question_db_name=question_db_name(rand(0, 4));
		$total=mysqli_num_rows(mysqli_query($con, "SELECT * FROM $question_db_name[0]"));
		$question_number=rand(1, $total);

		$result=mysqli_query($con, "SELECT * FROM $question_db_name[0] WHERE no='$question_number'");
		$row=mysqli_fetch_assoc($result);

		// echo "<h1>每日一題</h1>";
		// echo $row["question"]."<br/><br/>";
		// echo "A. ".$row["A"]."<br/>";
		// echo "B. ".$row["B"]."<br/>";
		// echo "C. ".$row["C"]."<br/>";
		// echo "D. ".$row["D"]."<br/><br/>";

		// echo "<button data-toggle='collapse' data-target='#demo'>解答</button><br/>";

		// echo "<div id='demo' class='collapse'>";
		// if(isset($_COOKIE["member_ID"]))
		// 	echo $row["answer"];
		// else
		// 	echo "登入看解答";
		// echo "</div>";

		?>

	</div>

</body>

</html>