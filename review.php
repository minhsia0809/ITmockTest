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
	<?php role_require(); ?>

	<title>題庫管理系統 | 資訊能力檢定模擬測驗</title>
</head>

<body>

	<div class="padding">

		<h2 align="center" style="font-weight: bold;">測驗結果</h2>
		<h4 align="center" style="padding-bottom: 32px;">從錯誤中學習 協助自己進步</h4>

		<?php

		$con=db_link();
		session_start();

		$member_ID=$_COOKIE["member_ID"];

		$result=mysqli_query($con, "SELECT * FROM user WHERE identity='$member_ID'");
		$row=mysqli_fetch_assoc($result);


		if(isset($_GET["mode"]))
		{
			if($_GET["mode"]=="practice")
			{
				$test_data=test_data($_COOKIE["transcript"]);
				$amount=count($test_data);
				$other_url_value["mode"]="practice";
			}
			else
				header("location: /itmocktest/review.php?page=1");
		}
		else
		{
			$test_data=test_data($row["transcript"]);
			$amount=50;
			$other_url_value=NULL;
		}

		pagination($_GET["page"], $amount/5, $other_url_value);

		?>

		<table width="100%" align="center" cellpadding="5" border="0">
			<!-- visibility: hidden; -->
			<tr style="visibility: hidden;">
				<td width="60"></td>
				<td width="50">1</td>
				<td width="50"></td>
				<td></td>
				<td width="75"></td>
			</tr>

			<?php

			for($i=($_GET["page"]-1)*5+1; $i<=$_GET["page"]*5; $i++)
			{
				$question_db_name=question_db_name($test_data[$i][0]);
				$question_number=$test_data[$i][1];

				$result=mysqli_query($con, "SELECT * FROM $question_db_name[0] WHERE no='$question_number'");
				$row=mysqli_fetch_assoc($result);

				echo "<tr>";
				echo "<td colspan='5'>";
				echo "<div style='font-size: 24px; color: #1591D5; font-weight: bold;'>".str_pad($i, 2, "0", STR_PAD_LEFT).".</div>";
				echo "</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td align='center' valign='bottom' colspan='2'>作答情形</td>";
				echo "<td align='center' valign='bottom'>選項</td>";
				echo "<td><font size='3'><b>".$row["question"]."</b></font></td>";
				echo "<td align='center' valign='bottom'>正解</td>";
				echo "</tr>";

				echo "<tr class='top_line'>";

				if($test_data[$i][2]=="N")
					echo "<td align='center' rowspan='4' style='background-color: #EAEDED;'>未作答</td>";
				else if($test_data[$i][2]==$row["answer"])
					echo "<td align='center' rowspan='4' style='background-color: #D5F5E3'>正確</td>";
				else
					echo "<td align='center' rowspan='4' style='background-color: #FADBD8'>錯誤</td>";

				echo "<td align='center'>".($test_data[$i][2]=="A" ? "✔" : "---")."</td>";
				echo "<td align='center' width='25'><b>(A)</b></td>";
				echo "<td ".correct_color($row["answer"], "A")."><div style='padding: 4px;'>".$row["A"]."</div></td>";
				echo "<td align='center' rowspan='4'>".$row["answer"]."</td>";
				echo "</tr>";

				echo "<tr class='top_line'>";
				echo "<td align='center'>".($test_data[$i][2]=="B" ? "✔" : "---")."</td>";
				echo "<td align='center' width='25'><b>(B)</b></td>";
				echo "<td ".correct_color($row["answer"], "B")."><div style='padding: 4px;'>".$row["B"]."</div></td>";
				echo "</tr>";

				echo "<tr class='top_line'>";
				echo "<td align='center'>".($test_data[$i][2]=="C" ? "✔" : "---")."</td>";
				echo "<td align='center' width='25'><b>(C)</b></td>";
				echo "<td ".correct_color($row["answer"], "C")."><div style='padding: 4px;'>".$row["C"]."</div></td>";
				echo "</tr>";

				echo "<tr class='top_line'>";
				echo "<td align='center'>".($test_data[$i][2]=="D" ? "✔" : "---")."</td>";
				echo "<td align='center' width='25'><b>(D)</b></td>";
				echo "<td ".correct_color($row["answer"], "D")."><div style='padding: 4px;'>".$row["D"]."</div></td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td colspan='5' align='right'><div style='font-size: 16px; font-weight: bold; color: #9E9E9E; padding-bottom: 32px;'>".$question_db_name[1]."_".str_pad($question_number, 3, "0", STR_PAD_LEFT)."</div></td>";
				echo "</tr>";
			}

			?>

		</table>

		<?php

		pagination($_GET["page"], $amount/5, $other_url_value);

		?>

	</div>

</body>

</html>