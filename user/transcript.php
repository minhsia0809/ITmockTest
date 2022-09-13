<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	<link rel="icon" href="/itmocktest/image/logo.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link href="../des.css" rel="stylesheet" type="text/css">

	<?php include("../utility_functions.php"); ?>
	<?php top_menu(); ?>
	<?php role_require(); ?>

	<title>測驗成績單 | 資訊能力檢定模擬測驗</title>
</head>

<body>

	<div class="padding">

		<h2 align="center" style="font-weight: bold;">測驗成績單</h2>
		<h4 align="center" style="padding-bottom: 32px;">正式測驗都會有成績單&emsp;檢視學習狀況</h4>

		<?php

		$con=db_link();
		session_start();

		date_default_timezone_set("Asia/Taipei");

		$member_ID=$_COOKIE["member_ID"];

		$result=mysqli_query($con, "SELECT * FROM user WHERE identity='$member_ID'");
		$user_row=mysqli_fetch_assoc($result);

		$test_data=test_data($user_row["transcript"]);

		echo "<div style='background-color: #D0ECE7; padding: 8px;'>";

		echo "<h3 align='center' style='font-weight: bold; padding-bottom: 8px;'>資訊能力檢定模擬測驗成績單</h3>";

		echo "<table width='100%' border='1' style='margin-bottom: 16px;'>";

		echo "<tr align='center'>";
		echo "<td width='25%'>考生序號</td>";
		echo "<td width='25%'>考生名稱</td>";
		echo "<td width='50%'>應試時間</td>";
		echo "</tr>";

		echo "<tr align='center'>";
		echo "<td>".identity_code($user_row["identity"])."</td>";
		echo "<td>".$user_row["username"]."</td>";
		echo "<td>".date("Y/m/d H:i:s", $user_row["test_time"])."</td>";
		echo "</tr>";

		echo "</table>";

		echo "<table width='100%' border='1' style='margin-bottom: 16px;'>";

		echo "<tr align='center'>";
		echo "<td rowspan='7'>成績</td>";
		echo "<td>題庫</td>";
		echo "<td>答對題數</td>";
		echo "<td>總題數</td>";
		echo "<td>實得分數</td>";
		echo "<td>滿分</td>";
		echo "<td>答對率</td>";

		echo "</tr>";

		$total_amount=array_fill(0, 5, 0);
		$correct_amount=array_fill(0, 5, 0);
		for($i=1; $i<=50; $i++)
		{
			$question_db_name=question_db_name($test_data[$i][0]);
			$question_number=$test_data[$i][1];

			$result=mysqli_query($con, "SELECT * FROM $question_db_name[0] WHERE no='$question_number'");
			$row=mysqli_fetch_assoc($result);

			if($test_data[$i][2]==$row["answer"])
				$correct_amount[$test_data[$i][0]]++;

			$total_amount[$test_data[$i][0]]++;
		}

		for($i=0; $i<=4; $i++)
		{
			$question_db_name=question_db_name($i);

			echo "<tr>";
			echo "<td>".$question_db_name[2]."&nbsp;".$question_db_name[1]."</td>";
			echo "<td align='center'>".$correct_amount[$i]."</td>";
			echo "<td align='center'>".$total_amount[$i]."</td>";
			echo "<td align='center'>".($correct_amount[$i]*2)."</td>";
			echo "<td align='center'>".($total_amount[$i]*2)."</td>";
			echo "<td align='center'>".round($correct_amount[$i]/$total_amount[$i]*100, 2)."%</td>";
			echo "</tr>";
		}


		echo "<tr height='42' align='center' style='border-top: 4px #000 double;'>";
		echo "<td>".final_review($user_row["last_score"])."</td>";
		echo "<td>總分</td>";
		echo "<td><b>".$user_row["last_score"]."</b></td>";
		echo "<td>測驗時長</td>";
		echo "<td><b>".floor($user_row["elapsed_time"]/60)."分鐘".($user_row["elapsed_time"]%60)."秒</b></td>";
		echo "<td>【".($user_row["last_score"]>=60 && $user_row["elapsed_time"]<=3600 ? "合格" : "不合格")."】</td>";
		echo "</tr>";

		echo "</table>";

		echo "<table width='100%' border='1' style='margin-bottom: 16px;'>";

		echo "<tr align='center'>";

		echo "<td rowspan='3'>作答情形</td>";
		for($i=1; $i<=50; $i++)
			echo "<td style='border: none;'>".($i%10==0 ? $i/10 : "·")."</td>";
		echo "</tr>";

		echo "<tr align='center'>";
		for($i=1; $i<=50; $i++)
			echo "<td style='border: none;'>".($i%10)."</td>";
		echo "</tr>";

		echo "<tr align='center'>";
		for($i=1; $i<=50; $i++)
		{
			$question_db_name=question_db_name($test_data[$i][0]);
			$question_number=$test_data[$i][1];

			$result=mysqli_query($con, "SELECT * FROM $question_db_name[0] WHERE no='$question_number'");
			$row=mysqli_fetch_assoc($result);

			echo "<td width='15' style='border: none;'>";
			if($test_data[$i][2]=="N")
				echo "-";
			else if($test_data[$i][2]==$row["answer"])
				echo "O";
			else
				echo "X";
			echo "</td>";
		}
		echo "</tr>";

		echo "</table>";

		echo "O：代表答對；X：答錯；空白：代表沒有作答<br/>";
		echo "備註：若總分低於60分，或是測驗時長超過60分鐘者，本次檢定將列為不合格。";

		echo "</div>";

		?>

		<button class="btn_s blue" onclick="javascript:location.href='/itmocktest/review.php'" style="margin: 16px; float: right;">查看考後檢討</button>

	</div>

</body>

</html>