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
	
	<title>資訊能力檢定模擬測驗</title>
</head>

<body>

	<div class="padding">

		<h2 align="center" style="font-weight: bold;">資訊能力檢定模擬測驗</h2>
		<h4 align="center" style="padding-bottom: 32px;">管理您的資訊、隱私權和安全性，打造您專屬的 Google 服務</h4>

		<form action="checking.php" method="POST">

			<?php

			session_start();

			echo "<input type='hidden' name='mode' value='".$_SESSION["mode"]."'>";
			echo "<input type='hidden' name='test_time' value='".$_SESSION["test_time"]."'>";

			if(is_null($_SESSION["Q"]))
				header("location: /itmocktest/choose.php");

			$con=db_link();

			for($i=1; $i<=$_SESSION["amount"]; $i++)
			{
				$question_db_name=question_db_name(floor($_SESSION["Q"][$i]/1000));
				$question_number=$_SESSION["Q"][$i]%1000;

				$result=mysqli_query($con, "SELECT * FROM $question_db_name[0] WHERE no='$question_number'");
				$row=mysqli_fetch_assoc($result);

				echo "<div style='font-size: 24px; color: #1591D5; font-weight: bold;'>".str_pad($i, 2, "0", STR_PAD_LEFT).".</div>";
				echo "<div style='font-size: 16px; padding: 16px; border-top: 1px #CCCCCC solid;' width='1000'>";
				echo $row["question"];
				echo "</div>";

				echo "<div class='radio-container' style='margin-bottom: 64px;'>";

				for($j="A"; $j<="D"; $j++)
				{
					echo "<input type='radio' name='Q".$i."' value='".$j."' class='radio-btn' id='".$j."_".$i."'>";
					echo "<label class='radio-label' for='".$j."_".$i."'>";
					echo "<span style='padding: 4px;'>(".$j.")</span>".$row[$j]."</label>";
				}

				echo "</div>";
			}
			?>

			<center>
				<button type="button" class="button_big og" data-toggle="modal" data-target="#turn_in">繳交考卷</button>
			</center>

			<div class="modal fade" id="turn_in">
				<div class="modal-dialog">
					<div class="modal-content">

						<div class="modal-header">
							<button class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">繳交考卷</h4>
						</div>

						<div class="modal-body">
							是否要繳交考卷？<br/>
							繳交前請確認作答情形，以及是否有題目未作答。<br/><br/>
						</div>

						<div class="modal-footer">
							<button class="btn btn-default" data-dismiss="modal">取消</button>
							<input class="btn btn-default" type="submit" value="繳交">
						</div>

					</div>
				</div>
			</div>

		</form>

	</div>

</body>

</html>