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

			session_start();
			ob_start();
			ob_flush();

			unset($_SESSION["Q"]);

			if(isset($_GET["mode"]))
				$_SESSION["mode"]=$_GET["mode"];
			else
			{	
				header("location: /itmocktest/choose.php");
				flush();
			}

			if(isset($_POST["type"]))
			{
				$con=db_link();

				$_SESSION["amount"]=$_POST["amount"];
				$_SESSION["test_time"]=time()+3;
				$pool=array();

				foreach($_POST["type"] as $value)
				{
					$question_db_name=question_db_name($value);
					$total=mysqli_num_rows(mysqli_query($con, "SELECT * FROM $question_db_name[0]"));

					$all_question=range(1+$value*1000, $total+$value*1000);
					$pool=array_merge($pool, $all_question);
				}

				shuffle($pool);

				for($i=1; $i<=$_SESSION["amount"]; $i++)
					$_SESSION["Q"][$i]=$pool[$i-1];

				echo "<h3 style='font-weight: bold;'>考試即將開始</h3>";
				echo "<div style='margin-bottom: 16px;'>本頁面將在3秒後自動跳轉至測驗畫面</div>";

				header("refresh: 3; url='/itmocktest/testing.php'");
				flush();
			}
			else
			{
				echo "<h3 style='font-weight: bold;'>錯誤</h3>";
				echo "請至少選擇一個題庫</br>";
				echo "<button class='btn_hint' onclick='javascript: location.href=\"/itmocktest/choose.php\"'>確認</button>";
			}

			?>

		</div>

	</div>

</body>

</html>