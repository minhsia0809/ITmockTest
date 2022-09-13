<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" href="/itmocktest/image/logo.ico" type="image/x-icon">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link href="../des.css" rel="stylesheet" type="text/css">

	<?php include("../utility_functions.php"); ?>

	<title>資訊能力檢定模擬測驗</title>
</head>

<body>

	<div class="newpadding">

		<div class="hint">

			<?php

			$username=$_POST["username"];
			$password=$_POST["password"];
			$last_login=time();

			$con=db_link();
			$result=mysqli_query($con, "SELECT * FROM user WHERE username='$username'");

			if($row=mysqli_fetch_assoc($result))
			{
				if(password_verify($password, $row["password"]))
				{
					$member_ID=$row["identity"];
					mysqli_query($con, "UPDATE user SET last_login='$last_login' WHERE identity='$member_ID'");

					if(isset($_POST["keep_login"]))
						setcookie("member_ID", $member_ID, time()+2592000, "/itmocktest/");
					else
						setcookie("member_ID", $member_ID, 0, "/itmocktest/");
				
					echo "<h3 style='font-weight: bold;'>登入成功</h3>";
					echo "返回首頁</br>";
					echo "<button class='btn_hint' onclick='javascript: location.href=\"/itmocktest/homepage.php\"'>確認</button>";
				}
				else
				{
					echo "<h3 style='font-weight: bold;'>登入失敗</h3>";
					echo "帳號或密碼錯誤</br>";
					echo "<button class='btn_hint' onclick='javascript: location.href=\"/itmocktest/homepage.php\"'>確認</button>";
				}
			}
			else
			{
				echo "<h3 style='font-weight: bold;'>登入失敗</h3>";
				echo "帳號或密碼錯誤</br>";
				echo "<button class='btn_hint' onclick='javascript: location.href=\"/itmocktest/homepage.php\"'>確認</button>";
			}

			?>

		</div>

	</div>

</body>

</html>