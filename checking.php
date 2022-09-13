<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" href="/itmocktest/image/logo.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link href="des.css" rel="stylesheet" type="text/css">

	<?php include("utility_functions.php"); ?>
	<?php role_require(); ?>

	<title>資訊能力檢定模擬測驗</title>
</head>

<body>

	<div class="newpadding">

		<div class="hint">

			<?php

			$con=db_link();
			session_start();

			$correct_count=0;
			$transcript="";

			for($i=1; $i<=$_SESSION["amount"]; $i++)
			{
				$question_serial_number=$_SESSION["Q"][$i];

				if(isset($_POST["Q".$i]))
				{
					$option=$_POST["Q".$i];

					$question_db_name=question_db_name(floor($question_serial_number/1000), false);
					$question_number=$question_serial_number%1000;

					$result=mysqli_query($con, "SELECT answer FROM $question_db_name[0] WHERE no='$question_number'");
					$row=mysqli_fetch_assoc($result);

					if($option==$row["answer"])
						$correct_count++;

					$option_time=$_POST["Q".$i]."_time";
					mysqli_query($con, "UPDATE $question_db_name[0] SET $option_time=$option_time+1 WHERE no='$question_number'");
				}
				else
					$option="N";

				$transcript.=sprintf("%04d%s", $question_serial_number, $option);
			}

			if($_POST["mode"]=="formal")
			{
				$member_ID=$_COOKIE["member_ID"];
				$score=$correct_count/$_SESSION["amount"]*100;
				$test_time=$_SESSION["test_time"];
				$elapsed_time=time()-$_SESSION["test_time"];

				$result=mysqli_query($con, "SELECT * FROM user WHERE identity='$member_ID'");
				$row=mysqli_fetch_assoc($result);

				mysqli_query($con, "UPDATE user SET last_score='$score', transcript='$transcript', test_time='$test_time', elapsed_time='$elapsed_time' WHERE identity='$member_ID'");

				if($score>=$row["high_score"])
					mysqli_query($con, "UPDATE user SET high_score='$score' WHERE identity='$member_ID'");

				echo "<h3 style='font-weight: bold;'>成績計算中</h3>";
				echo "<div style='margin-bottom: 16px;'>本頁面將在3秒後自動跳轉至測驗成績單畫面</div>";

				header("refresh: 3; url='/itmocktest/user/transcript.php'");
				flush();
			}
			else if($_POST["mode"]=="practice")
			{
				setcookie("transcript", $transcript, time()+600);

				echo "<h3 style='font-weight: bold;'>成績計算中</h3>";
				echo "<div style='margin-bottom: 16px;'>本頁面將在3秒後自動跳轉至測驗結果畫面</div>";

				header("refresh: 3; url='/itmocktest/review.php?mode=practice&page=1'");
				flush();
			}

			unset($_SESSION["Q"]);
			unset($_SESSION["amount"]);

			?>

		</div>

	</div>

</body>

</html>